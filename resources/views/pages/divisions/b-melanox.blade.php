@extends('layouts.site')

@section('title', 'B-Melanox™ — Pigmentation Science')
@section('description', "B-Melanox is ORIGINA's scientific pigmentation division and BMX-24™ pigment regulation platform for skin of colour.")
@section('body-class', 'division-page division-page--melanox')

@section('content')
  @php
    $focusAreas = [
      'Hyperpigmentation',
      'Post-inflammatory pigmentation',
      'Melasma',
      'Uneven skin tone',
      'Pigment regulation',
      'Barrier preservation',
      'Long-term management',
    ];

    $products = [
      [
        'image' => 'https://raw.githubusercontent.com/PHENOMVALENCE/origina-next/main/public/img/products/bmelanox-01.jpeg',
        'alt' => 'B-Melanox pigment cream product presentation',
        'label' => '01 · Current expression',
        'title' => 'B-Melanox Pigment Cream',
        'text' => 'Primary intensive pigment-management formulation. Product claims, availability, and protocols remain subject to formal validation.',
      ],
      [
        'image' => 'https://raw.githubusercontent.com/PHENOMVALENCE/origina-next/main/public/img/products/bmelanox-03.jpeg',
        'alt' => 'B-Melanox supportive cleansing system',
        'label' => '02 · Support system',
        'title' => 'B-Melanox Cleanser',
        'text' => 'Supportive cleansing system designed to complement pigment-management protocols without compromising barrier integrity.',
      ],
      [
        'image' => 'https://raw.githubusercontent.com/PHENOMVALENCE/origina-next/main/public/img/products/bmelanox-06.jpeg',
        'alt' => 'B-Melanox exfoliant product system',
        'label' => '03 · Support system',
        'title' => 'B-Melanox Exfoliant',
        'text' => 'Controlled resurfacing and pigment-renewal support within a disciplined product ecosystem.',
      ],
    ];

    $future = [
      ['num' => 'I', 'title' => 'Professional protocols', 'text' => 'Structured approaches for qualified professionals — future development.'],
      ['num' => 'II', 'title' => 'Clinical programs', 'text' => 'Evaluation and long-term management frameworks where scientifically and regulatorily appropriate.'],
      ['num' => 'III', 'title' => 'Additional formulations', 'text' => 'Extended product ecosystem beyond current expressions.'],
      ['num' => 'IV', 'title' => 'Diagnostic / assessment tools', 'text' => 'Tools to support disciplined pigment assessment — subject to validation.'],
      ['num' => 'V', 'title' => 'Scientific publications', 'text' => 'Research documentation released as work reaches appropriate disclosure standards.'],
      ['num' => 'VI', 'title' => 'Treatment systems', 'text' => 'Integrated systems — only where classification and evidence support such description.'],
    ];
  @endphp

  <x-page-hero
    :dark="true"
    kicker="Scientific pigmentation division"
    crumb="Divisions / B-Melanox™"
    title="Pigmentation is"
    accent="biology."
    intro="B-Melanox is ORIGINA's pigmentation-science division — with skin of colour as its starting population, not its limit."
    image="https://raw.githubusercontent.com/PHENOMVALENCE/origina-next/main/public/img/products/bmelanox-01.jpeg"
    alt="B-Melanox Night Intensive Pigment Corrector product presentation"
    caption="B-Melanox™ · Institutional product preview"
  />

  <section class="division-rail" aria-label="B-Melanox identity">
    <div class="site-shell">
      <span>B-Melanox™</span>
      <span>BMX-24™</span>
      <span>Pigmentation science</span>
      <span>Skin of colour</span>
    </div>
  </section>

  <x-section tone="paper" eyebrow="01 · Question" title="The research question.">
    <div class="melanox-question">
      <blockquote>How can excessive or dysregulated pigmentation be addressed without relying on conventional hydroquinone-based approaches, while developing a system appropriate for melanin-rich skin?</blockquote>
      <div class="melanox-seal" aria-hidden="true">B</div>
    </div>
  </x-section>

  <x-section tone="sunk" eyebrow="Platform" title="BMX-24™" intro="Proprietary pigment regulation platform. Clinical studies are not yet complete — wording remains appropriately conservative.">
    <p class="lead-serif institution-lead">Developed as a proprietary pigment-regulation platform originating from research into non-hydroquinone approaches to hyperpigmentation in skin of colour.</p>
  </x-section>

  <x-section tone="noir" eyebrow="Focus areas" title="Understand the whole pathway." intro="Pigmentation cannot be approached in isolation from inflammation, barrier integrity, exposure, and long-term management.">
    <div class="focus-grid">
      @foreach($focusAreas as $area)
        <article>
          <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          <p>{{ $area }}</p>
        </article>
      @endforeach
    </div>
  </x-section>

  <x-section tone="paper" eyebrow="02 · Expression" title="The current expression." intro="A first look at the B-Melanox product system. Product claims, availability, protocols, and commercial details remain subject to formal approval before publication.">
    <div class="product-grid">
      @foreach($products as $product)
        <article class="product-card">
          <figure>
            <img src="{{ $product['image'] }}" alt="{{ $product['alt'] }}" loading="lazy" width="900" height="1125">
          </figure>
          <p class="meta-label">{{ $product['label'] }}</p>
          <h3>{{ $product['title'] }}</h3>
          <p>{{ $product['text'] }}</p>
        </article>
      @endforeach
    </div>
  </x-section>

  <section class="product-dossier">
    <div class="site-shell product-dossier__grid">
      <div class="product-gallery">
        <img class="product-gallery__primary" src="https://raw.githubusercontent.com/PHENOMVALENCE/origina-next/main/public/img/products/bmelanox-01.jpeg" alt="B-Melanox Night Intensive Pigment Corrector with its carton" loading="lazy" width="1200" height="1500">
        <div class="product-gallery__secondary">
          <img src="https://raw.githubusercontent.com/PHENOMVALENCE/origina-next/main/public/img/products/bmelanox-04.jpeg" alt="B-Melanox material study" loading="lazy" width="900" height="900">
          <img src="https://raw.githubusercontent.com/PHENOMVALENCE/origina-next/main/public/img/products/bmelanox-06.jpeg" alt="B-Melanox complete presentation" loading="lazy" width="900" height="900">
        </div>
      </div>

      <div class="product-dossier__copy">
        <p class="eyebrow">Product dossier · 01</p>
        <h2>Night Intensive<br><span>Pigment Corrector.</span></h2>
        <p class="lead-serif">The first visible product expression of the B-Melanox pigmentation-science platform.</p>

        <dl class="dossier-facts">
          <div><dt>Format</dt><dd>Targeted night serum</dd></div>
          <div><dt>Platform</dt><dd>B-Melanox · ORIGINA Labs</dd></div>
          <div><dt>Focus</dt><dd>Uneven tone and visible pigmentation</dd></div>
          <div><dt>Status</dt><dd>Institutional preview</dd></div>
        </dl>

        <details open>
          <summary>How it fits the ritual</summary>
          <p>Designed as a considered evening step within a broader routine that respects barrier integrity, consistency, and professional guidance where appropriate.</p>
        </details>
        <details>
          <summary>Scientific approach</summary>
          <p>The platform studies pigmentation alongside inflammation, exposure, skin-barrier condition, and long-term management. Formal ingredient and claim information will follow validation.</p>
        </details>
        <details>
          <summary>Availability and safety</summary>
          <p>This presentation is institutional, not commercial. Availability, directions, ingredients, suitability, and claims remain subject to final regulatory and scientific approval.</p>
        </details>
      </div>
    </div>
  </section>

  <x-section tone="sunk" eyebrow="03 · Horizon" title="Beyond the product shelf.">
    <p class="status-chip">Future development</p>
    <div class="future-list">
      @foreach($future as $item)
        <div>
          <span>{{ $item['num'] }}</span>
          <article><h3>{{ $item['title'] }}</h3><p>{{ $item['text'] }}</p></article>
        </div>
      @endforeach
    </div>
  </x-section>

  <aside class="disclaimer-band">
    <div class="site-shell">
      <strong>Scientific & regulatory notice</strong>
      <p>B-Melanox website content is institutional information and does not replace individual medical advice. Product claims and availability remain subject to formal validation and approval.</p>
    </div>
  </aside>

  <section class="closing-cta closing-cta--melanox">
    <div class="site-shell closing-cta__inner">
      <div>
        <p class="eyebrow eyebrow--dark">Scientific enquiries</p>
        <h2>Advance the conversation.</h2>
        <p>For scientific, clinical, manufacturing, distribution, or institutional enquiries concerning B-Melanox.</p>
      </div>
      <div class="closing-cta__actions">
        <a class="button button--light" href="/contact">Contact B-Melanox</a>
        <a class="text-link text-link--dark" href="/labs">Explore ORIGINA Labs™</a>
      </div>
    </div>
  </section>
@endsection
