@extends('layouts.site')

@section('title', $page['title'])
@section('description', $page['description'])
@section('body-class', $page['body_class'] ?? '')

@section('content')
  @php
    $hero = $page['hero'] ?? [];
    $heroDark = (bool) ($hero['dark'] ?? false);
  @endphp

  <x-page-hero
    :dark="$heroDark"
    :kicker="$hero['kicker'] ?? 'ORIGINA'"
    :crumb="$hero['crumb'] ?? null"
    :title="$hero['title'] ?? $page['title']"
    :accent="$hero['accent'] ?? null"
    :intro="$hero['intro'] ?? null"
    :image="$hero['image'] ?? null"
    :alt="$hero['alt'] ?? ''"
    :caption="$hero['caption'] ?? null"
  />

  @if(!empty($page['nav']))
    <x-section-nav :items="$page['nav']" />
  @endif

  @foreach($page['sections'] ?? [] as $section)
    @php
      $type = $section['type'] ?? 'prose';
      $tone = $section['tone'] ?? 'paper';
      $items = $section['items'] ?? [];

      if (!empty($section['items_from'])) {
        $items = $directories[$section['items_from']] ?? [];
      }

      $darkSection = in_array($tone, ['noir', 'deep'], true);
    @endphp

    <x-section
      :id="$section['id'] ?? null"
      :tone="$tone"
      :eyebrow="$section['eyebrow'] ?? null"
      :title="$section['title'] ?? null"
      :intro="$section['intro'] ?? null"
    >
      @switch($type)
        @case('split')
          <div class="editorial-split {{ !empty($section['reverse']) ? 'editorial-split--reverse' : '' }}">
            <div class="institutional-copy">
              @if(!empty($section['lead']))
                <p class="lead-serif {{ $darkSection ? 'lead-serif--light' : '' }}">{{ $section['lead'] }}</p>
              @endif

              @foreach($section['paragraphs'] ?? [] as $paragraph)
                <p class="body-copy {{ $darkSection ? 'body-copy--light' : '' }} spaced-copy">{{ $paragraph }}</p>
              @endforeach

              @if(!empty($section['items']))
                <ul class="institutional-list">
                  @foreach($section['items'] as $item)
                    <li>{{ is_array($item) ? ($item['title'] ?? '') : $item }}</li>
                  @endforeach
                </ul>
              @endif

              @if(!empty($section['quote']))
                <blockquote class="editorial-quote {{ $darkSection ? 'editorial-quote--dark' : '' }}">{{ $section['quote'] }}</blockquote>
              @endif
            </div>

            @if(!empty($section['image']))
              <x-media
                :src="$section['image']"
                :alt="$section['image_alt'] ?? ''"
                :caption="$section['caption'] ?? null"
                ratio="portrait"
                width="900"
                height="1200"
              />
            @endif
          </div>
          @break

        @case('cards')
          <div class="institutional-card-grid">
            @foreach($items as $item)
              <article class="institutional-card">
                @if(!empty($item['meta']))
                  <p class="meta-label meta-label--accent">{{ $item['meta'] }}</p>
                @endif
                <h3>{{ $item['title'] }}</h3>
                @if(!empty($item['text']))
                  <p>{{ $item['text'] }}</p>
                @endif
                @if(!empty($item['href']))
                  <a class="text-link" href="{{ $item['href'] }}">Explore</a>
                @endif
              </article>
            @endforeach
          </div>
          @break

        @case('numbered')
          <div class="institutional-sequence">
            @foreach($items as $item)
              <article>
                <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <div>
                  <h3>{{ is_array($item) ? ($item['title'] ?? '') : $item }}</h3>
                  @if(is_array($item) && !empty($item['text']))
                    <p>{{ $item['text'] }}</p>
                  @endif
                </div>
              </article>
            @endforeach
          </div>
          @break

        @case('detail')
          <div class="institutional-detail-list">
            @foreach($items as $item)
              <article>
                <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                <div>
                  <h3>{{ $item['title'] }}</h3>
                  @if(!empty($item['text']))
                    <p>{{ $item['text'] }}</p>
                  @endif
                </div>
              </article>
            @endforeach
          </div>

          @if(!empty($section['quote']))
            <blockquote class="editorial-quote">{{ $section['quote'] }}</blockquote>
          @endif
          @break

        @case('tags')
          @if(!empty($section['lead']))
            <p class="lead-serif institution-lead">{{ $section['lead'] }}</p>
          @endif

          <div class="institutional-tags" role="list">
            @foreach($items as $item)
              <span role="listitem">{{ is_array($item) ? ($item['title'] ?? '') : $item }}</span>
            @endforeach
          </div>
          @break

        @case('statement-list')
          <div class="institutional-statements">
            @foreach($items as $item)
              <blockquote>{{ is_array($item) ? ($item['title'] ?? '') : $item }}</blockquote>
            @endforeach
          </div>
          @break

        @case('statement')
          <div class="institutional-statement">
            @if(!empty($section['quote']))
              <blockquote>{{ $section['quote'] }}</blockquote>
            @endif
            @if(!empty($section['meta']))
              <p>{{ $section['meta'] }}</p>
            @endif
          </div>
          @break

        @case('directory')
          <div class="institutional-directory">
            @foreach($items as $item)
              <article>
                <div class="institutional-directory__meta">
                  <span>{{ $item['meta'] ?? str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                  @if(!empty($item['subtitle']))
                    <span>{{ $item['subtitle'] }}</span>
                  @endif
                </div>
                <div class="institutional-directory__body">
                  <h3>{{ $item['title'] }}</h3>
                  @if(!empty($item['text']))
                    <p>{{ $item['text'] }}</p>
                  @endif
                </div>
                @if(!empty($item['href']))
                  <a href="{{ $item['href'] }}" class="{{ $darkSection ? 'text-link text-link--dark' : 'text-link' }}">
                    {{ $item['link'] ?? 'Explore' }}
                  </a>
                @endif
              </article>
            @endforeach
          </div>
          @break

        @case('contact')
          <div class="contact-panel">
            <div>
              <p class="lead-serif">Every serious enquiry is read with care.</p>
              <a class="contact-panel__email" href="mailto:{{ $section['email'] }}">{{ $section['email'] }}</a>
              @if(!empty($section['notice']))
                <p class="contact-panel__notice">{{ $section['notice'] }}</p>
              @endif
            </div>
            <dl>
              @foreach($items as $item)
                <div>
                  <dt>{{ $item['label'] }}</dt>
                  <dd>{{ $item['value'] }}</dd>
                </div>
              @endforeach
            </dl>
          </div>
          @break

        @case('empty')
          <div class="archive-empty">
            <span aria-hidden="true">Ø</span>
            <p class="lead-serif">{{ $section['lead'] ?? 'No records yet.' }}</p>
            @if(!empty($section['text']))
              <p class="body-copy">{{ $section['text'] }}</p>
            @endif
          </div>
          @break

        @case('legal')
          <div class="legal-prose">
            @foreach($items as $item)
              <section>
                <h2>{{ $item['title'] }}</h2>
                @foreach($item['paragraphs'] ?? [] as $paragraph)
                  <p>{{ $paragraph }}</p>
                @endforeach
              </section>
            @endforeach
          </div>
          @break

        @default
          <div class="institutional-prose">
            @if(!empty($section['lead']))
              <p class="lead-serif {{ $darkSection ? 'lead-serif--light' : '' }}">{{ $section['lead'] }}</p>
            @endif
            @foreach($section['paragraphs'] ?? [] as $paragraph)
              <p class="body-copy {{ $darkSection ? 'body-copy--light' : '' }}">{{ $paragraph }}</p>
            @endforeach
            @if(!empty($section['quote']))
              <blockquote class="editorial-quote {{ $darkSection ? 'editorial-quote--dark' : '' }}">{{ $section['quote'] }}</blockquote>
            @endif
          </div>
      @endswitch
    </x-section>
  @endforeach

  @if(!empty($page['cta']))
    <section class="closing-cta">
      <div class="site-shell closing-cta__inner">
        <div>
          @if(!empty($page['cta']['eyebrow']))
            <p class="eyebrow eyebrow--dark">{{ $page['cta']['eyebrow'] }}</p>
          @endif
          <h2>{{ $page['cta']['title'] }}</h2>
        </div>
        <div class="closing-cta__actions">
          @foreach($page['cta']['links'] ?? [] as $link)
            @if(!empty($link['secondary']))
              <a class="text-link text-link--dark" href="{{ $link['href'] }}">{{ $link['label'] }}</a>
            @else
              <a class="button button--light" href="{{ $link['href'] }}">{{ $link['label'] }}</a>
            @endif
          @endforeach
        </div>
      </div>
    </section>
  @endif
@endsection
