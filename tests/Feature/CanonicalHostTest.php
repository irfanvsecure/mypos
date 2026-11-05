<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanonicalHostTest extends TestCase
{
    use RefreshDatabase;

    public function test_http_goes_to_https_and_keeps_path_and_query(): void
    {
        $this->get('http://mypos.pk/pricing?plan=a')
            ->assertStatus(301)
            ->assertRedirect('https://mypos.pk/pricing?plan=a');
    }

    public function test_www_goes_to_the_bare_domain_in_one_hop(): void
    {
        foreach (['http://www.mypos.pk/contact', 'https://www.mypos.pk/contact'] as $url) {
            $this->get($url)->assertStatus(301)->assertRedirect('https://mypos.pk/contact');
        }
    }

    public function test_post_keeps_its_method(): void
    {
        $this->post('http://mypos.pk/enquiry')->assertStatus(308)->assertRedirect('https://mypos.pk/enquiry');
    }

    public function test_canonical_https_gets_hsts(): void
    {
        config(['site.hsts_max_age' => 86400]);

        $this->get('https://mypos.pk/robots.txt')
            ->assertOk()
            ->assertHeader('Strict-Transport-Security', 'max-age=86400');
    }

    public function test_hsts_can_be_switched_off(): void
    {
        config(['site.hsts_max_age' => 0]);

        $this->get('https://mypos.pk/robots.txt')->assertOk()->assertHeaderMissing('Strict-Transport-Security');
    }

    public function test_other_hosts_are_left_alone(): void
    {
        $this->get('http://localhost/robots.txt')->assertOk()->assertHeaderMissing('Strict-Transport-Security');
    }
}
