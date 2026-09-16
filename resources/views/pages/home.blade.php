@extends('layouts.site')

@section('title', 'ORIGINA — Biology First™')
@section('description', 'ORIGINA is a multi-divisional innovation institution built at the intersection of biology, clinical science, technology, and human wellbeing. Beginning in Africa. Serving the world.')

@section('content')
  <section class="home-hero" aria-labelledby="home-hero-title">
    <div class="site-shell home-hero__grid">
      <div class="home-hero__content reveal">
        <p class="eyebrow">Biology First™ · Evidence-led innovation</p>
        <h1 id="home-hero-title">Beginning in Africa.<span>Serving the world.</span></h1>
        <p class="home-hero__lede">A multi-divisional innovation institution built at the intersection of biology, clinical science, technology, and human wellbeing.</p>
        <div class="home-hero__actions">
          <x-button href="/about">Explore ORIGINA</x-button>
          <a class="text-link" href="/labs">Enter ORIGINA Labs™</a>
        </div>
        <p class="home-hero__meta">Research · Biology · Africa <span>·</span> Dar es Salaam, Tanzania · Est. 2024</p>
      </div>

      <figure class="home-hero__media reveal">
        <img src="/img/founder/founder-08.jpeg" alt="Dr. Elizabeth Consoli with a multidisciplinary professional community" width="1600" height="1200" fetchpriority="high">
        <figcaption>Expertise grows through community · Dar es Salaam, Tanzania</figcaption>
      </figure>
    </div>
  </section>

  <div class="institution-rail" aria-hidden="true">
    <div class="site-shell">ORIGINA / Institution · Biology First™ · Evidence-led innovation</div>
  </div>

  <x-section id="institution" tone="paper" eyebrow="01 · The institution" title="We begin with biology." intro="Human biology is interconnected. ORIGINA studies systems — not symptoms in isolation — before designing intervention.">
    <div class="editorial-split editorial-split--reverse">
      <div class="system-lines">
        <div><span>01</span><strong>Organisation</strong><small>Observe the whole system.</small></div>
        <div><span>02</span><strong>Interaction</strong><small>Map meaningful relationships.</small></div>
        <div><span>03</span><strong>Intervention</strong><small>Change only what evidence supports.</small></div>
        <p class="lead-serif">Understand the biological system before attempting to change it.</p>
      </div>
      <div>
        <figure class="editorial-image">
          <img src="/img/founder/founder-03.jpeg" alt="Dr. Elizabeth Consoli receiving recognition from dermatology peers" loading="lazy" width="1200" height="900">
          <figcaption>Science · Community · Recognition</figcaption>
        </figure>
        <p class="body-copy">Skin of colour is ORIGINA's first scientific specialization — populations historically underrepresented within dermatological research, clinical evidence, and product development. It is our starting point, not our limitation.</p>
        <a class="text-link" href="/about">Learn about ORIGINA</a>
      </div>
    </div>
  </x-section>

  <x-section tone="noir" eyebrow="02 · Why ORIGINA exists" title="Skin of colour is where we begin.">
    <div class="editorial-split">
      <p class="lead-serif lead-serif--light">What changes when human biology is studied from the perspective of melanin-rich skin?</p>
      <div>
        <p class="body-copy body-copy--light">Biology First™ is the framework that governs how ORIGINA asks questions, designs research, and evaluates claims — organisation, interaction, intervention, evidence and responsibility.</p>
        <blockquote class="pull-quote">Skin colour is an important biological and clinical consideration — not a single biological category.</blockquote>
        <a class="text-link text-link--dark" href="/biology-first">Explore Biology First™</a>
      </div>
    </div>
  </x-section>

  <x-section id="work" tone="sunk" eyebrow="03 · What we do" title="The scientific engine of ORIGINA." intro="From hypothesis to technical file, ORIGINA translates biological questions into evidence, prototypes, and repeatable methods.">
    <div class="indexed-list">
      <a href="/labs"><span>01</span><div><strong>ORIGINA Labs™</strong><p>The institutional R&D engine — research, formulation, clinical science, intellectual property, and manufacturing development.</p></div><em>Enter ORIGINA Labs™</em></a>
      <a href="/science"><span>02</span><div><strong>Development framework</strong><p>Thirteen disciplined stages connecting scientific curiosity to responsible commercial output.</p></div><em>Examine the framework</em></a>
      <a href="/platforms"><span>03</span><div><strong>Science platforms</strong><p>Proprietary platform architecture connecting research direction, evidence and future product expression.</p></div><em>View the platforms</em></a>
    </div>
  </x-section>

  <x-section id="divisions" tone="paper" eyebrow="04 · Divisions" title="A scientific institution — not a single brand." intro="Distinct expressions. Shared institution. Products are outputs; brands are expressions.">
    <div class="division-grid">
      @foreach(array_slice(config('origina.divisions', []), 0, 3) as $division)
        <a class="division-card division-card--{{ $division['tone'] }}" href="/divisions/{{ $division['slug'] }}">
          <span class="division-card__index">ORIGINA / {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          <div>
            <h3>{{ $division['name'] }}</h3>
            <p>{{ $division['descriptor'] }}</p>
          </div>
          <span class="division-card__arrow" aria-hidden="true">↗</span>
        </a>
      @endforeach
    </div>
    <a class="text-link section-link" href="/divisions">See all divisions</a>
  </x-section>

  <section class="quote-band">
    <div class="site-shell quote-band__inner">
      <blockquote>“If the evidence is preliminary, we call it preliminary. If the evidence is strong, we show it. If we do not know, we say we do not know.”</blockquote>
      <p>ORIGINA · Responsible science</p>
    </div>
  </section>

  <x-section tone="paper" eyebrow="05 · Evidence & responsibility" title="Ambition without scientific inflation." intro="Evidence has levels, and quality is designed in. ORIGINA is ambitious scientifically and conservative in claims.">
    <p class="body-copy measure">ORIGINA will not deliberately use unsupported clinically proven claims, exaggerated anti-ageing claims, unauthorized disease-treatment claims, or regulatory language implying approval where approval has not occurred.</p>
    <div class="link-row">
      <a class="text-link" href="/science/evidence">Understand evidence & quality</a>
      <a class="text-link" href="/science/responsible-science">Read the responsible science doctrine</a>
    </div>
  </x-section>

  <x-section id="founder" tone="sunk" eyebrow="06 · Founder" title="Dr. Elizabeth Consoli">
    <div class="founder-grid">
      <figure class="editorial-image editorial-image--portrait">
        <img src="/img/founder/founder-01.jpeg" alt="Dr. Elizabeth Consoli in her clinical environment" loading="lazy" width="900" height="1200">
        <figcaption>Scientific direction · Dar es Salaam</figcaption>
      </figure>
      <div class="founder-copy">
        <p class="meta-label">MD, MBChB · Medical Doctor · Cosmetic Formulation Scientist</p>
        <p class="lead-serif">Scientific innovation does not need to originate elsewhere to become globally relevant.</p>
        <p class="body-copy">Founder & Director — ORIGINA™. Founder / Scientific Director — ORIGINA Labs™. Creator — BMX-24™ platform. Focus — skin of colour, formulation science, and biological systems.</p>
        <a class="text-link" href="/founder">Read the founder profile</a>
      </div>
    </div>
  </x-section>

  <x-section tone="noir" eyebrow="07 · Africa originating" title="Africa is the origin. Not the limitation.">
    <div class="editorial-split">
      <p class="lead-serif lead-serif--light">Dar es Salaam is presented proudly — as the place where ORIGINA begins.</p>
      <div>
        <p class="body-copy body-copy--light">Africa can originate scientific platforms, clinical research, advanced formulations, intellectual property, technology, global brands, and new institutions.</p>
        <blockquote class="pull-quote">The ambition is not to build an African version of an existing foreign company. The ambition is to build something globally relevant that happens to have originated in Africa.</blockquote>
        <a class="text-link text-link--dark" href="/africa">Explore Africa originating</a>
      </div>
    </div>
  </x-section>

  <x-section id="future" tone="paper" eyebrow="08 · The horizon" title="Built for expansion with discipline." intro="A staged institutional horizon — an academy, a research institute, and new ventures — advanced only as the evidence and capacity are ready.">
    <div class="horizon-grid">
      <article><span>I</span><h3>Academy</h3><p>Structured knowledge, training and scientific communication.</p></article>
      <article><span>II</span><h3>Research Institute</h3><p>A future home for deeper investigation and interdisciplinary work.</p></article>
      <article><span>III</span><h3>Ventures</h3><p>New institutional expressions developed with evidence and discipline.</p></article>
    </div>
    <a class="text-link section-link" href="/future">View the institutional horizon</a>
  </x-section>

  <section class="closing-cta">
    <div class="site-shell closing-cta__inner">
      <div>
        <p class="eyebrow eyebrow--dark">Build with ORIGINA</p>
        <h2>Enquire with ORIGINA.</h2>
        <p>Scientific collaboration, manufacturing development, investment, brand partnerships, and scientific communication.</p>
      </div>
      <div class="closing-cta__actions">
        <a class="button button--light" href="/contact">Enquire with ORIGINA</a>
        <a class="text-link text-link--dark" href="/labs">Enter ORIGINA Labs™</a>
      </div>
    </div>
  </section>
@endsection
