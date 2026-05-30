<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $slug = $this->route('slug');

        return match ($slug) {
            'home'       => $this->homeRules(),
            'news'       => $this->newsPageRules(),
            'services'   => $this->servicesRules(),
            'membership' => $this->membershipRules(),
            'markets'    => $this->marketsRules(),
            'report'     => $this->reportRules(),
            'tenderzone' => $this->tenderzoneRules(),
            default      => ['content' => ['required', 'array']],
        };
    }

    private function i18n(string $prefix, int $max = 500): array
    {
        return [
            "{$prefix}.ru" => ['required', 'string', "max:{$max}"],
            "{$prefix}.uz" => ['required', 'string', "max:{$max}"],
            "{$prefix}.en" => ['required', 'string', "max:{$max}"],
        ];
    }

    private function homeRules(): array
    {
        return array_merge(
            // Hero
            $this->i18n('content.hero.title_1'),
            $this->i18n('content.hero.title_2'),
            $this->i18n('content.hero.title_3'),
            $this->i18n('content.hero.subtitle'),
            $this->i18n('content.hero.btn_primary.label'),
            ['content.hero.btn_primary.href'   => ['required', 'string', 'max:255']],
            $this->i18n('content.hero.btn_secondary.label'),
            ['content.hero.btn_secondary.href' => ['required', 'string', 'max:255']],

            // About
            $this->i18n('content.about.heading'),
            $this->i18n('content.about.all_services_label'),
            ['content.about.features'          => ['required', 'array', 'size:4']],
            ['content.about.features.*.icon'   => ['required', 'string']],
            $this->i18n('content.about.features.*.title'),
            $this->i18n('content.about.features.*.desc'),
            ['content.about.services'                => ['required', 'array', 'size:5']],
            ['content.about.services.*.image'        => ['required', 'string', 'max:500']],
            $this->i18n('content.about.services.*.tag'),
            $this->i18n('content.about.services.*.title'),
            $this->i18n('content.about.services.*.desc'),

            // Stats
            $this->i18n('content.stats.label'),
            $this->i18n('content.stats.heading'),
            ['content.stats.items'            => ['required', 'array', 'size:4']],
            ['content.stats.items.*.icon'     => ['required', 'string']],
            $this->i18n('content.stats.items.*.value', 50),
            $this->i18n('content.stats.items.*.label'),

            // Partners
            $this->i18n('content.partners.heading'),
            ['content.partners.logos'         => ['required', 'array']],
            ['content.partners.logos.*.src'   => ['required', 'string', 'max:500']],
            ['content.partners.logos.*.alt'   => ['required', 'string', 'max:255']],

            // Contacts
            $this->i18n('content.contacts.label'),
            $this->i18n('content.contacts.heading'),
            $this->i18n('content.contacts.address_value'),
            ['content.contacts.phone'         => ['required', 'string', 'max:50']],
            ['content.contacts.email'         => ['required', 'email', 'max:255']],

            // Footer
            $this->i18n('content.footer.tagline'),
            $this->i18n('content.footer.description'),
        );
    }

    private function newsPageRules(): array
    {
        return array_merge(
            $this->i18n('content.hero.title'),
            $this->i18n('content.hero.subtitle'),
        );
    }

    private function servicesRules(): array
    {
        return ['content' => ['required', 'array']];
    }

    private function membershipRules(): array
    {
        return ['content' => ['required', 'array']];
    }

    private function marketsRules(): array
    {
        return array_merge(
            $this->i18n('content.hero.badge'),
            $this->i18n('content.hero.title_1'),
            $this->i18n('content.hero.title_2'),
            $this->i18n('content.hero.subtitle', 1000),
        );
    }

    private function tenderzoneRules(): array
    {
        return array_merge(
            // Hero
            $this->i18n('content.hero.badge'),
            $this->i18n('content.hero.title_1'),
            $this->i18n('content.hero.title_2'),
            $this->i18n('content.hero.title_3'),
            $this->i18n('content.hero.subtitle', 1000),
            $this->i18n('content.hero.btn_primary.label'),
            ['content.hero.btn_primary.href'   => ['required', 'string', 'max:255']],
            $this->i18n('content.hero.btn_secondary.label'),
            ['content.hero.btn_secondary.href' => ['required', 'string', 'max:255']],
            // Features section
            $this->i18n('content.features.badge'),
            $this->i18n('content.features.heading'),
            $this->i18n('content.features.subtitle', 1000),
            // How it works
            $this->i18n('content.how.badge'),
            $this->i18n('content.how.heading'),
            $this->i18n('content.how.btn_primary.label'),
            ['content.how.btn_primary.href'   => ['required', 'string', 'max:255']],
            $this->i18n('content.how.btn_secondary.label'),
            ['content.how.btn_secondary.href' => ['required', 'string', 'max:255']],
            $this->i18n('content.how.cta_hint', 1000),
            // Modal
            $this->i18n('content.modal.free_title'),
            $this->i18n('content.modal.demo_title'),
            $this->i18n('content.modal.free_desc', 1000),
            $this->i18n('content.modal.demo_desc', 1000),
        );
    }

    private function reportRules(): array
    {
        return array_merge(
            // Hero
            $this->i18n('content.hero.badge'),
            $this->i18n('content.hero.title'),
            $this->i18n('content.hero.subtitle'),
            // Info banner
            $this->i18n('content.info_banner.text'),
            $this->i18n('content.info_banner.days'),
            $this->i18n('content.info_banner.after_text'),
            $this->i18n('content.info_banner.track_word'),
            $this->i18n('content.info_banner.suffix'),
            // Sidebar
            $this->i18n('content.sidebar.info_title'),
            // Form tabs
            $this->i18n('content.form.tabs.submit'),
            $this->i18n('content.form.tabs.track'),
            // Form fields
            $this->i18n('content.form.section1_title'),
            $this->i18n('content.form.label_org'),
            $this->i18n('content.form.label_tender'),
            $this->i18n('content.form.label_date'),
            $this->i18n('content.form.label_desc'),
            $this->i18n('content.form.section2_title'),
            $this->i18n('content.form.section2_optional', 50),
            $this->i18n('content.form.upload_title'),
            $this->i18n('content.form.upload_hint'),
            $this->i18n('content.form.section3_title'),
            $this->i18n('content.form.anon_label'),
            $this->i18n('content.form.anon_hint'),
            $this->i18n('content.form.label_name'),
            $this->i18n('content.form.label_sender_org'),
            $this->i18n('content.form.label_phone'),
            $this->i18n('content.form.label_email'),
            $this->i18n('content.form.agree_text', 1000),
            $this->i18n('content.form.agree_privacy'),
            $this->i18n('content.form.agree_and', 20),
            $this->i18n('content.form.agree_rules'),
            $this->i18n('content.form.btn_submit'),
            $this->i18n('content.form.btn_call'),
            // Track
            $this->i18n('content.track.sidebar_title'),
            $this->i18n('content.track.search_title'),
            $this->i18n('content.track.search_hint'),
            $this->i18n('content.track.btn_find', 50),
            $this->i18n('content.track.empty_title'),
            $this->i18n('content.track.empty_hint'),
            $this->i18n('content.track.not_found_title'),
            $this->i18n('content.track.not_found_text', 1000),
            $this->i18n('content.track.stages_title'),
            $this->i18n('content.track.btn_new'),
            $this->i18n('content.track.btn_call', 50),
            // Success modal
            $this->i18n('content.success_modal.title'),
            $this->i18n('content.success_modal.subtitle'),
            $this->i18n('content.success_modal.track_label'),
            $this->i18n('content.success_modal.btn_copy', 50),
            $this->i18n('content.success_modal.btn_copied', 50),
            $this->i18n('content.success_modal.email_prefix'),
            $this->i18n('content.success_modal.meta_category', 100),
            $this->i18n('content.success_modal.meta_date', 100),
            $this->i18n('content.success_modal.meta_expert', 100),
            $this->i18n('content.success_modal.meta_deadline', 100),
            $this->i18n('content.success_modal.expert_name'),
            $this->i18n('content.success_modal.category_name'),
            $this->i18n('content.success_modal.btn_track'),
            $this->i18n('content.success_modal.btn_close', 50),
        );
    }
}
