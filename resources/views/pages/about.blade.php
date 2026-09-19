@extends('layouts.site')

@section('title', 'About ORIGINA — Innovation Institution')
@section('description', "Discover ORIGINA's mission, vision, philosophy, founder, and institutional purpose.")

@section('content')
  @php
    $sections = [
      ['id' => 'identity', 'label' => 'Identity'],
      ['id' => 'purpose', 'label' => 'Purpose'],
      ['id' => 'philosophy', 'label' => 'Philosophy'],
      ['id' => 'founder', 'label' => 'Founder'],
      ['id' => 'mandate', 'label' => 'Mandate'],
      ['id' => 'architecture', 'label' => 'Architecture'],
    ];

    $beliefs = [
      ['title' => 'Great ideas', 'text' => 'can come from anywhere.'],
      ['title' => 'Curiosity', 'text' => 'is where innovation begins.'],
      ['title' => 'Excellence', 'text' => 'is a standard, not a goal.'],
      ['title' => 'Knowledge', 'text' => 'must lead to action.'],
      ['title' => 'Science & creativity', 'text' => 'are complementary.'],
      ['title' => 'Long-term impact', 'text' => 'matters more than short-term gain.'],
      ['title' => 'Institutions', 'text' => 'outlive individuals.'],
    ];

    $timeline = [
      ['period' => '2024', 'title' => 'ORIGINA established', 'text' => 'A long-term institutional vision takes form in Dar es Salaam.'],
      ['period' => 'Now', 'title' => 'Scientific direction', 'text' => 'Research discipline, formulation logic, and standards are embedded in every programme.'],
      ['period' => 'Next', 'title' => 'Institutional expansion', 'text' => 'Teams, partnerships, and knowledge systems grow around the mission — not around one personality.'],
    ];

    $roles = [
      ['num' => '01', 'title' => 'Scientific direction', 'text' => 'Led by Dr. Elizabeth Consoli, safeguarding scientific standards and programme integrity.'],
      ['num' => '02', 'title' => 'Research & formulation', 'text' => 'Translating complex questions into evidence, prototypes, and repeatable methods.'],
      ['num' => '03', 'title' => 'Institutional development', 'text' => 'Building the systems, culture, and operating model required for lasting work.'],
      ['num' => '04', 'title' => 'Strategic partnerships', 'text' => 'Connecting aligned collaborators, manufacturing capability, and global opportunity.'],
    ];
  @endphp

  <x-page-hero
    kicker="The institution"
    crumb="Institution"
    title="Created for what"
    accent="does not yet exist."
    intro="ORIGINA is an innovation institution dedicated to the discovery, development, and advancement of ideas, technologies, products, systems, and people that improve human life."
    image="/img/founder/founder-01.jpeg"
    alt="Dr. Elizabeth Consoli in her clinical environment"
    caption="Scientific direction · Dar es Salaam"
  />

  <x-section-nav :items="$sections" />

  <x-section id="identity" tone="paper" eyebrow="01 · Identity" title="What ORIGINA is." intro="A home for thinkers and builders. A multi-industry platform. A long-term legacy organisation.">
    <p class="lead-serif institution-lead">ORIGINA exists to create what does not yet exist. Extraordinary progress comes from extraordinary thinking — and innovation should never be limited by credentials, hierarchy, industry boundaries, or conventional approaches.</p>

    <div class="definition-grid">
      <article class="definition-card">
        <span class="meta-label meta-label--accent">Not</span>
        <p>A skincare company<br>A cosmetics company<br>A personal brand<br>A single-industry business</p>
      </article>
      <article class="definition-card definition-card--emphasis">
        <span class="meta-label meta-label--accent">Yes</span>
        <p>An innovation institution<br>A home for builders<br>A multi-industry platform<br>A legacy organisation</p>
      </article>
    </div>
  </x-section>

  <x-section id="purpose" tone="sunk" eyebrow="02 · Purpose">
    <div class="purpose-grid">
      <article>
        <p class="meta-label meta-label--accent">Mission</p>
        <h2>Turn knowledge<br>into <span>action.</span></h2>
        <p class="body-copy">To discover, create, and advance transformative solutions that improve human life through science, innovation, craftsmanship, and exceptional thinking.</p>
      </article>
      <article>
        <p class="meta-label meta-label--accent">Vision</p>
        <h2>Emerge from Africa.<br><span>Resonate globally.</span></h2>
        <p class="body-copy">To become one of the most respected innovation institutions emerging from Africa, recognised globally for exceptional ideas, exceptional people, and exceptional solutions.</p>
      </article>
    </div>
  </x-section>

  <x-section id="philosophy" tone="noir" eyebrow="03 · Philosophy" title="The beliefs beneath the work." intro="Our philosophy guides every decision, formula, collaboration, and hire.">
    <div class="principle-list">
      @foreach($beliefs as $belief)
        <div class="principle-row">
          <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          <h3>{{ $belief['title'] }}</h3>
          <p>{{ $belief['text'] }}</p>
        </div>
      @endforeach
    </div>
  </x-section>

  <x-section id="founder" tone="paper" eyebrow="04 · Founder">
    <div class="founder-profile">
      <figure class="editorial-image editorial-image--portrait">
        <img src="{{ asset('img/founder/founder-01.jpeg') }}" alt="Dr. Elizabeth Consoli in her clinical environment" loading="lazy" width="900" height="1200">
        <figcaption>Scientific direction · Dar es Salaam</figcaption>
      </figure>
      <div>
        <h2 class="section-display">Dr. Elizabeth<br><span>Consoli.</span></h2>
        <p class="lead-serif">Medical doctor. Cosmetic formulator. Skin of colour specialist. Institution builder.</p>
        <p class="body-copy spaced-copy">ORIGINA begins under Dr. Consoli's direct scientific direction in Dar es Salaam. The founder's role is not to make ORIGINA a personal brand, but to establish the standard, systems, and intellectual culture from which an enduring institution can grow.</p>
        <a class="text-link" href="/founder">Read the founder profile</a>
      </div>
    </div>
  </x-section>

  <section class="quote-band quote-band--editorial">
    <div class="site-shell quote-band__inner">
      <blockquote>“The future is created by people willing to think beyond existing limitations.”</blockquote>
      <p>Dr. Elizabeth Consoli · Founder</p>
    </div>
  </section>

  <x-section id="mandate" tone="paper" eyebrow="05 · Mandate">
    <div class="mandate-grid">
      <div>
        <h2 class="section-display">Set the standard.<br><span>Build beyond self.</span></h2>
        <p class="lead-serif">The founder establishes the intellectual culture; the institution is designed to carry it forward.</p>
        <ol class="timeline-list">
          @foreach($timeline as $item)
            <li>
              <span>{{ $item['period'] }}</span>
              <div><h3>{{ $item['title'] }}</h3><p>{{ $item['text'] }}</p></div>
            </li>
          @endforeach
        </ol>
      </div>
      <div class="photo-pair" aria-label="ORIGINA institutional photography">
        <img src="{{ asset('img/founder/founder-02.jpeg') }}" alt="Dr. Elizabeth Consoli at a professional event" loading="lazy" width="900" height="1100">
        <img src="{{ asset('img/founder/founder-09.jpeg') }}" alt="Dr. Elizabeth Consoli in professional conversation" loading="lazy" width="900" height="1100">
      </div>
    </div>
  </x-section>

  <x-section id="architecture" tone="sunk" eyebrow="06 · Architecture" title="The roles that move ideas forward." intro="ORIGINA is building a multidisciplinary organisation. These functions define the capability being assembled as the institution grows.">
    <div class="role-grid">
      @foreach($roles as $role)
        <article class="role-card">
          <span>{{ $role['num'] }}</span>
          <h3>{{ $role['title'] }}</h3>
          <p>{{ $role['text'] }}</p>
        </article>
      @endforeach
    </div>
  </x-section>

  <section class="closing-cta">
    <div class="site-shell closing-cta__inner">
      <div>
        <p class="eyebrow eyebrow--dark">Continue exploring</p>
        <h2>See where ideas become research.</h2>
      </div>
      <div class="closing-cta__actions">
        <a class="button button--light" href="/labs">Enter ORIGINA Labs™</a>
        <a class="text-link text-link--dark" href="/contact">Contact ORIGINA</a>
      </div>
    </div>
  </section>
@endsection
