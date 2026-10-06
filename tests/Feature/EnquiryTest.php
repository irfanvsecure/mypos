<?php

namespace Tests\Feature;

use App\Mail\NewEnquiry;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EnquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_enquiry_is_stored_and_emailed(): void
    {
        Mail::fake();

        $this->from('/contact')->post('/enquiry', [
            'name' => 'Ali Khan', 'business' => 'Khan Mart', 'phone' => '0300 1234567',
            'email' => 'ali@example.com', 'type' => 'Sales Enquiry', 'message' => 'Need POS for 2 branches', 'page' => 'contact',
        ])->assertRedirect('/contact')->assertSessionHas('enquiry_ok');

        $this->assertDatabaseHas('leads', ['name' => 'Ali Khan', 'phone' => '0300 1234567', 'page' => 'contact']);
        Mail::assertSent(NewEnquiry::class, fn ($m) => $m->hasTo(config('site.leads_email')));
    }

    public function test_name_and_phone_are_required(): void
    {
        $this->from('/contact')->post('/enquiry', ['phone' => 'abc'])
            ->assertRedirect('/contact')
            ->assertSessionHasErrors(['name', 'phone']);

        $this->assertSame(0, Lead::count());
    }

    public function test_honeypot_submissions_are_discarded(): void
    {
        Mail::fake();

        $this->from('/contact')->post('/enquiry', ['name' => 'Bot', 'phone' => '0300 1234567', 'website' => 'http://spam.example'])
            ->assertRedirect('/contact');

        $this->assertSame(0, Lead::count());
        Mail::assertNothingSent();
    }
}
