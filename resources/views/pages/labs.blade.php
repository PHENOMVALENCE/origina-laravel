@extends('layouts.site')

@section('title', 'ORIGINA Labs — Research & Development')
@section('description', 'ORIGINA Labs is the scientific engine of ORIGINA: biological research, formulation science, analytical development, safety, clinical evaluation, IP, and manufacturing translation.')

@section('content')
  @php
    $sections = [
      ['id' => 'function', 'label' => 'Institutional function'],
      ['id' => 'capabilities', 'label' => 'Capabilities'],
      ['id' => 'continuum', 'label' => 'Continuum'],
      ['id' => 'research', 'label' => 'Horizon'],
      ['id' => 'archive', 'label' => 'Knowledge archive'],
    ];

    $capabilities = [
      ['num' => '01', 'title' => 'Formulate', 'text' => 'Design proprietary formulas from first principles for melanin-rich skin biology.'],
      ['num' => '02', 'title' => 'Research', 'text' => 'Build the scientific investigation beneath every product claim and protocol.'],
      ['num' => '03', 'title' => 'Evaluate', 'text' => 'Test and validate formulas against dermatological standards for skin of colour.'],
      ['num' => '04', 'title' => 'Protect', 'text' => 'Document and strategically protect innovation as institutional intellectual property.'],
      ['num' => '05', 'title' => 'Archive', 'text' => 'Grow an evidence-based institutional knowledge system around every discovery.'],
      ['num' => '06', 'title' => 'Scale', 'text' => 'Bridge laboratory innovation to controlled manufacturing and global distribution.'],
    ];

    $continuum = [
      ['step' => '01', 'title' => 'Question', 'text' => 'Define the unmet human or scientific need.'],
      ['step' => '02', 'title' => 'Investigate', 'text' => 'Build evidence, hypotheses, and design criteria.'],
      ['step' => '03', 'title' => 'Formulate', 'text' => 'Translate knowledge into a viable intervention.'],
      ['step' => '04', 'title' => 'Evaluate', 'text' => 'Test performance, safety, and suitability.'],
      ['step' => '05', 'title' => 'Scale', 'text' => 'Prepare a controlled path to manufacturing.'],
    ];

    $futureFields = ['Dermatology', 'Regenerative technologies', 'Personal care', 'Medical devices', 'Nutritional science', 'Fields yet to emerge'];

    $research = [
      ['meta' => 'Foundational programme · Active', 'title' => 'B-Melanox™ formulation platform', 'text' => 'Investigating a disciplined product system for visible uneven tone and melanin-rich skin.', 'footer' => 'Programme 01 · 2024—ongoing'],
      ['meta' => 'Research question · Scoping', 'title' => 'Contextual drivers of uneven pigmentation', 'text' => 'Mapping environmental, behavioural, and biological variables to improve how formulation questions are framed.', 'footer' => 'Field note · In development'],
      ['meta' => 'Protocol · Development', 'title' => 'Barrier-first evaluation framework', 'text' => 'Building a repeatable approach to evaluating tolerance and suitability without separating efficacy from skin-barrier health.', 'footer' => 'Protocol 02 · Internal review'],
      ['meta' => 'Methods · Active', 'title' => 'From formulation logic to controlled scale', 'text' => 'Documenting the decisions required to protect formula intent as laboratory work moves toward manufacturing.', 'footer' => 'Methods brief · 2025—ongoing'],
    ];
  @endphp

  <x-page-hero
    kicker="ORIGINA / Science"
    crumb="ORIGINA Labs™"
    title="The scientific engine"
    accent="of ORIGINA."
    intro="Research · Formulation · Clinical Science · IP · Manufacturing Development"
    image="/img/founder/founder-03.jpeg"
    alt="Dr. Elizabeth Consoli receiving recognition from dermatology peers"
    caption="Science · Community · Recognition"
  />

  <x-section-nav :items="$sections" />

  <x-section id="function" tone="paper" eyebrow="01 · Institutional function">
    <div class="labs-intro-grid">
      <div>
        <h2 class="section-display">An R&D organisation,<br><span>not a label.</span></h2>
        <p class="lead-serif">ORIGINA Labs represents an institutional research and development function — translating biological questions into evidence, prototypes, technical files, and repeatable methods.</p>
        <p class="body-copy spaced-copy">Every breakthrough formula, proprietary platform, evaluation protocol, and manufacturing pathway begins here under direct scientific direction.</p>
      </div>
      <figure class="editorial-image editorial-image--portrait">
        <img src="/img/founder/founder-03.jpeg" alt="Dr. Elizabeth Consoli receiving recognition from dermatology peers" loading="lazy" width="900" height="1200">
        <figcaption>Science · Community · Recognition</figcaption>
      </figure>
    </div>
  </x-section>

  <x-section id="capabilities" tone="noir" eyebrow="02 · Capabilities" title="Six connected capabilities." intro="An institutional R&D architecture — closer to a research organisation than a cosmetics page.">
    <div class="capability-grid">
      @foreach($capabilities as $capability)
        <article class="capability-card">
          <span>{{ $capability['num'] }}</span>
          <h3>{{ $capability['title'] }}</h3>
          <p>{{ $capability['text'] }}</p>
        </article>
      @endforeach
    </div>
  </x-section>

  <x-section id="continuum" tone="sunk" eyebrow="03 · Continuum" title="From question to repeatable output." intro="Five connected stages within the broader development framework.">
    <div class="continuum-grid">
      @foreach($continuum as $item)
        <article>
          <span>{{ $item['step'] }}</span>
          <h3>{{ $item['title'] }}</h3>
          <p>{{ $item['text'] }}</p>
        </article>
      @endforeach
    </div>
  </x-section>

  <x-section id="research" tone="paper" eyebrow="04 · Horizon">
    <div class="labs-horizon-grid">
      <figure class="editorial-image editorial-image--portrait">
        <img src="/img/founder/founder-05.jpeg" alt="Dr. Elizabeth Consoli discussing skin-care formulation" loading="lazy" width="900" height="1200">
        <figcaption>Knowledge in practice</figcaption>
      </figure>
      <div>
        <h2 class="section-display">Skin science is<br><span>the beginning.</span></h2>
        <p class="body-copy spaced-copy">The Labs framework expands when excellence can be sustained — subject to scientific feasibility and institutional capacity.</p>
        <div class="tag-list">
          @foreach($futureFields as $field)
            <span>{{ $field }}</span>
          @endforeach
        </div>
      </div>
    </div>
  </x-section>

  <x-section id="archive" tone="sunk" eyebrow="05 · Knowledge archive" title="Research in active development." intro="A living index of questions, protocols, and evidence streams. Public briefs are released as work reaches appropriate disclosure standards — not before.">
    <div class="research-grid">
      @foreach($research as $item)
        <article class="research-card">
          <p class="meta-label">{{ $item['meta'] }}</p>
          <h3>{{ $item['title'] }}</h3>
          <p>{{ $item['text'] }}</p>
          <footer>{{ $item['footer'] }}</footer>
        </article>
      @endforeach
    </div>
  </x-section>

  <section class="closing-cta">
    <div class="site-shell closing-cta__inner">
      <div>
        <p class="eyebrow eyebrow--dark">Research relationships</p>
        <h2>Bring a serious question.</h2>
        <p>Scientific collaboration begins with a clearly framed problem, an evidence standard, and an honest view of what is known.</p>
      </div>
      <div class="closing-cta__actions">
        <a class="button button--light" href="/contact?subject=scientific#enquiry-form">Research enquiries</a>
        <a class="text-link text-link--dark" href="/platforms">Scientific platforms</a>
      </div>
    </div>
  </section>
@endsection
