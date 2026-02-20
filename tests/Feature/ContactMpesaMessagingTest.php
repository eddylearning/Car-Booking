<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Car;
use App\Models\ContactMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ContactMpesaMessagingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create(['name' => 'user']);
        Role::create(['name' => 'employee']);
    }

    public function test_contact_form_submission_is_saved(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'message' => 'Need help with booking.',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contact_messages', [
            'email' => 'jane@example.com',
            'message' => 'Need help with booking.',
        ]);
    }

    public function test_user_booking_messaging_yes_no_and_store_work(): void
    {
        $user = User::factory()->create();
        $user->assignRole('user');

        $car = Car::create([
            'name' => 'Test Car',
            'model' => '2024',
            'type' => 'SUV',
            'mileage' => 1000,
            'price_per_day' => 5000,
            'available' => true,
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDay()->toDateString(),
            'location' => 'Nairobi',
            'total_price' => 10000,
            'status' => 'pending',
        ]);

        $this->actingAs($user)
            ->post(route('user.messages.store'), [
                'booking_id' => $booking->id,
                'message' => 'Is this available?',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('messages', [
            'booking_id' => $booking->id,
            'sender_role' => 'user',
            'message' => 'Is this available?',
        ]);

        $this->actingAs($user)
            ->post(route('user.messages.yes', $booking))
            ->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'approved',
        ]);

        $this->actingAs($user)
            ->post(route('user.messages.no', $booking))
            ->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'rejected',
        ]);
    }

    public function test_employee_confirm_and_stk_message_flow_works_with_http_fake(): void
    {
        Http::fake([
            'https://sandbox.safaricom.co.ke/oauth/v1/generate*' => Http::response([
                'access_token' => 'fake-token',
            ], 200),
            'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest' => Http::response([
                'ResponseCode' => '0',
                'ResponseDescription' => 'Success',
            ], 200),
        ]);

        $employee = User::factory()->create();
        $employee->assignRole('employee');

        $user = User::factory()->create();
        $user->assignRole('user');

        $car = Car::create([
            'name' => 'Test Car 2',
            'model' => '2025',
            'type' => 'Sedan',
            'mileage' => 2000,
            'price_per_day' => 6000,
            'available' => true,
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'car_id' => $car->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'location' => 'Mombasa',
            'total_price' => 12000,
            'status' => 'pending',
        ]);

        $this->actingAs($employee)
            ->post(route('employee.messages.confirm', $booking->id))
            ->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'approved',
        ]);

        $this->actingAs($employee)
            ->post(route('employee.messages.stk'), [
                'booking_id' => $booking->id,
                'phone' => '254712345678',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('messages', [
            'booking_id' => $booking->id,
            'sender_role' => 'system',
            'message' => 'STK Push sent to 254712345678',
        ]);

        Http::assertSentCount(2);
    }
}
