<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\Media;
use App\Site\ImageAttributes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RenderingFixesTest extends TestCase
{
    use RefreshDatabase;

    private function media(string $path): void
    {
        Media::create(['path' => $path, 'width' => 640, 'height' => 360, 'size_bytes' => 1, 'mime' => 'image/png']);
    }

    public function test_images_get_their_size_from_the_media_library(): void
    {
        $this->media('uploads/a.png');

        $out = ImageAttributes::apply('<img src="https://mypos.pk/uploads/a.png" alt="A">');

        $this->assertStringContainsString('width="640" height="360"', $out);
        $this->assertStringNotContainsString('loading=', $out);
    }

    public function test_existing_attributes_and_unknown_images_are_left_alone(): void
    {
        $this->media('uploads/a.png');
        $own = '<img src="/uploads/a.png" width="10" height="20" alt="A">';
        $unknown = '<img src="/uploads/other.png" alt="B">';

        $this->assertSame($own, ImageAttributes::apply($own));
        $this->assertSame($unknown, ImageAttributes::apply($unknown));
    }

    public function test_posts_lazy_load_every_image_after_the_first(): void
    {
        $out = ImageAttributes::apply('<img src="/x.png"><img src="/y.png"><img src="/z.png" loading="eager">', true);

        $this->assertSame('<img src="/x.png"><img loading="lazy" decoding="async" src="/y.png"><img src="/z.png" loading="eager">', $out);
    }

    public function test_a_repeat_enquiry_within_a_minute_is_not_saved_or_emailed_twice(): void
    {
        Mail::fake();
        $form = ['name' => 'Test', 'phone' => '03001234567', 'type' => 'Free Demo', 'page' => '/'];

        $first = $this->post('/enquiry', $form)->assertRedirect(route('thank-you'))->getSession()->get('pixel_events');
        $second = $this->post('/enquiry', $form)->assertRedirect(route('thank-you'))->getSession()->get('pixel_events');

        $this->assertSame(1, Lead::count());
        Mail::assertSentCount(1);
        $this->assertSame($first[0]['event_id'], $second[0]['event_id']);
    }

    public function test_the_same_person_can_enquire_again_later_or_about_something_else(): void
    {
        Mail::fake();
        $form = ['name' => 'Test', 'phone' => '03001234567', 'type' => 'Free Demo', 'page' => '/'];

        $this->post('/enquiry', $form);
        $this->post('/enquiry', ['type' => 'Sales Enquiry'] + $form);
        $this->travel(2)->minutes();
        $this->post('/enquiry', $form);

        $this->assertSame(3, Lead::count());
    }

    public function test_analytics_loads_only_with_an_id_and_on_an_allowed_host(): void
    {
        $tag = 'googletagmanager.com/gtag/js?id=G-TEST12345';

        config(['services.google_analytics.id' => 'G-TEST12345', 'services.google_analytics.hosts' => ['mypos.pk']]);
        $this->get('http://localhost/thank-you')->assertDontSee($tag, false);
        $this->get('https://mypos.pk/thank-you')->assertSee($tag, false);

        config(['services.google_analytics.id' => '']);
        $this->get('https://mypos.pk/thank-you')->assertDontSee('googletagmanager.com', false);
    }
}
