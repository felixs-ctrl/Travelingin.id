<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use App\Mail\DpConfirmed;
use App\Mail\PelunasanConfirmed;
use Tests\TestCase;

class BookingPaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_payment_flow()
    {
        Mail::fake();

        // 1. Create User and Destination
        $user = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);
        
        $destination = Destination::create([
            'name' => 'Trip Bali',
            'description' => 'Beautiful Bali',
            'price' => 1000000,
            'quota' => 10,
            'loyalty_points' => 10,
            'type' => 'paket',
            'package_type' => 'general',
            'whatsapp_link' => 'https://chat.whatsapp.com/test-wa-link'
        ]);

        // 2. Checkout Store Action
        $response = $this->actingAs($user)->post(route('bookings.store'), [
            'destination_id' => $destination->id,
            'nama' => 'Test User',
            'email' => $user->email,
            'no_hp' => '08123456789',
            'jumlah_orang' => 2,
            'tanggal_booking' => now()->addDays(10)->format('Y-m-d'),
        ]);

        $booking = Booking::first();
        $this->assertNotNull($booking);
        $this->assertEquals(2000000, $booking->total_price);
        $this->assertEquals(600000, $booking->dp_amount);
        $this->assertEquals('pending', $booking->status);

        // 3. User Uploads DP Proof
        $file = UploadedFile::fake()->create('payment_proof.png', 100, 'image/png');
        $response = $this->actingAs($user)->post(route('bookings.confirmPayment', $booking->id), [
            'payment_proof' => $file,
        ]);

        $booking->refresh();
        $this->assertEquals('dp_processed', $booking->status);
        $this->assertNotNull($booking->payment_proof);
        $this->assertNull($booking->pelunasan_proof);

        // 4. Admin Confirms DP
        $response = $this->actingAs($admin)->patch(route('admin.orders.confirmDp', $booking->id));
        $booking->refresh();
        $this->assertEquals('confirmed', $booking->status);

        Mail::assertSent(DpConfirmed::class, function ($mail) use ($booking) {
            return $mail->booking->id === $booking->id;
        });

        // 5. User Uploads Pelunasan Proof
        $pelunasanFile = UploadedFile::fake()->create('pelunasan_proof.png', 100, 'image/png');
        $response = $this->actingAs($user)->post(route('bookings.confirmPayment', $booking->id), [
            'payment_proof' => $pelunasanFile,
        ]);

        $booking->refresh();
        $this->assertEquals('pelunasan_processed', $booking->status);
        $this->assertNotNull($booking->pelunasan_proof);

        // 6. Admin Confirms Pelunasan
        $response = $this->actingAs($admin)->patch(route('admin.orders.confirmPelunasan', $booking->id));
        $booking->refresh();
        $this->assertEquals('lunas', $booking->status);

        Mail::assertSent(PelunasanConfirmed::class, function ($mail) use ($booking) {
            return $mail->booking->id === $booking->id;
        });

        // 7. Verify Invoice Page Access
        $response = $this->actingAs($user)->get(route('bookings.invoice', $booking->id));
        $response->assertStatus(200);
        $response->assertSee('INVOICE');
        $response->assertSee($booking->nama);

        // Security: Another user cannot access
        $otherUser = User::factory()->create();
        $response = $this->actingAs($otherUser)->get(route('bookings.invoice', $booking->id));
        $response->assertStatus(403);
    }
}
