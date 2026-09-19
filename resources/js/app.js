const header = document.querySelector('[data-site-header]');
const toggle = document.querySelector('[data-menu-toggle]');
const mobileNav = document.querySelector('[data-mobile-nav]');
const menuIcon = document.querySelector('[data-menu-icon]');
const menuLabel = document.querySelector('[data-menu-label]');
const menuClose = document.querySelector('[data-menu-close]');
const desktopNav = document.querySelector('[data-desktop-nav]');
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

const canAnimate = () => !reducedMotion.matches && typeof Element.prototype.animate === 'function';

const animate = (element, keyframes, options) => {
  if (!element || !canAnimate()) return null;

  element.getAnimations().forEach((animation) => animation.cancel());

  return element.animate(keyframes, {
    fill: 'both',
    ...options,
  });
};

const setDesktopPanelState = (item, open, immediate = false) => {
  const trigger = item?.querySelector('[data-nav-trigger]');
  const panel = item?.querySelector('[data-nav-panel]');
  if (!trigger || !panel) return;

  trigger.setAttribute('aria-expanded', String(open));

  if (open) {
    panel.hidden = false;

    if (!immediate) {
      animate(
        panel,
        [
          { opacity: 0, transform: 'translateX(-50%) translateY(-0.45rem) scale(.985)' },
          { opacity: 1, transform: 'translateX(-50%) translateY(0) scale(1)' },
        ],
        { duration: 220, easing: 'cubic-bezier(.22, 1, .36, 1)' },
      );
    }

    return;
  }

  if (panel.hidden) return;

  if (immediate || !canAnimate()) {
    panel.hidden = true;
    return;
  }

  const closing = animate(
    panel,
    [
      { opacity: 1, transform: 'translateX(-50%) translateY(0) scale(1)' },
      { opacity: 0, transform: 'translateX(-50%) translateY(-0.3rem) scale(.99)' },
    ],
    { duration: 150, easing: 'cubic-bezier(.4, 0, 1, 1)' },
  );

  closing?.finished
    .catch(() => null)
    .finally(() => {
      if (trigger.getAttribute('aria-expanded') !== 'true') panel.hidden = true;
    });
};

const closeDesktopPanels = (except = null, immediate = false) => {
  if (!desktopNav) return;

  desktopNav.querySelectorAll('[data-nav-item]').forEach((item) => {
    if (item !== except) setDesktopPanelState(item, false, immediate);
  });
};

if (desktopNav) {
  desktopNav.querySelectorAll('[data-nav-item]').forEach((item) => {
    const trigger = item.querySelector('[data-nav-trigger]');
    const panel = item.querySelector('[data-nav-panel]');
    if (!trigger || !panel) return;

    trigger.addEventListener('click', (event) => {
      event.stopPropagation();
      const opening = trigger.getAttribute('aria-expanded') !== 'true';

      closeDesktopPanels(item);
      setDesktopPanelState(item, opening);
    });
  });

  document.addEventListener('click', (event) => {
    if (!desktopNav.contains(event.target)) closeDesktopPanels();
  });
}

let restoreMenuFocus = true;

const focusableElements = () => {
  if (!mobileNav) return [];

  return [...mobileNav.querySelectorAll(
    'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])',
  )].filter((element) => !element.hasAttribute('hidden'));
};

const setMenuState = (open, { restoreFocus = true, immediate = false } = {}) => {
  if (!header || !toggle || !mobileNav) return;

  restoreMenuFocus = restoreFocus;
  toggle.setAttribute('aria-expanded', String(open));
  toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
  document.documentElement.classList.toggle('menu-open', open);
  document.body.style.overflow = open ? 'hidden' : '';

  if (menuIcon) menuIcon.textContent = open ? '✕' : '☰';
  if (menuLabel) menuLabel.textContent = open ? 'Close navigation' : 'Open navigation';

  if (open) {
    mobileNav.hidden = false;

    if (!immediate) {
      animate(
        mobileNav,
        [{ opacity: 0 }, { opacity: 1 }],
        { duration: 240, easing: 'cubic-bezier(.22, 1, .36, 1)' },
      );

      const inner = mobileNav.querySelector('.mobile-nav__inner');
      animate(
        inner,
        [
          { opacity: 0, transform: 'translateY(.75rem)' },
          { opacity: 1, transform: 'translateY(0)' },
        ],
        { duration: 340, easing: 'cubic-bezier(.22, 1, .36, 1)' },
      );
    }

    window.requestAnimationFrame(() => menuClose?.focus());
    return;
  }

  const finishClose = () => {
    if (toggle.getAttribute('aria-expanded') === 'false') mobileNav.hidden = true;
    if (restoreMenuFocus) toggle.focus();
  };

  if (immediate || !canAnimate()) {
    finishClose();
    return;
  }

  const closing = animate(
    mobileNav,
    [{ opacity: 1 }, { opacity: 0 }],
    { duration: 170, easing: 'cubic-bezier(.4, 0, 1, 1)' },
  );

  closing?.finished
    .catch(() => null)
    .finally(finishClose);
};

if (header && toggle && mobileNav) {
  toggle.addEventListener('click', () => {
    setMenuState(toggle.getAttribute('aria-expanded') !== 'true');
  });

  menuClose?.addEventListener('click', () => setMenuState(false));

  mobileNav.addEventListener('click', (event) => {
    if (event.target.closest('a')) setMenuState(false, { restoreFocus: false });
  });
}

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') {
    closeDesktopPanels();

    if (toggle?.getAttribute('aria-expanded') === 'true') {
      setMenuState(false);
    }

    return;
  }

  if (
    event.key !== 'Tab'
    || !mobileNav
    || toggle?.getAttribute('aria-expanded') !== 'true'
  ) return;

  const focusable = focusableElements();
  if (!focusable.length) return;

  const first = focusable[0];
  const last = focusable[focusable.length - 1];

  if (event.shiftKey && document.activeElement === first) {
    event.preventDefault();
    last.focus();
  } else if (!event.shiftKey && document.activeElement === last) {
    event.preventDefault();
    first.focus();
  }
});

const syncHeaderState = () => {
  if (!header) return;
  header.dataset.scrolled = String(window.scrollY > 18);
};

let headerFrame = null;
window.addEventListener('scroll', () => {
  if (headerFrame) return;

  headerFrame = window.requestAnimationFrame(() => {
    syncHeaderState();
    headerFrame = null;
  });
}, { passive: true });

syncHeaderState();

const sectionNav = document.querySelector('.section-nav');
const sectionNavTrack = sectionNav?.querySelector('.section-nav__track');
const sectionLinks = sectionNav
  ? [...sectionNav.querySelectorAll('a[href^="#"]')]
  : [];

const sectionTargets = sectionLinks
  .map((link) => {
    const id = link.getAttribute('href')?.slice(1);
    const section = id ? document.getElementById(id) : null;
    return section ? { link, section } : null;
  })
  .filter(Boolean);

const setActiveSection = (link) => {
  sectionTargets.forEach(({ link: item }) => {
    const active = item === link;
    item.classList.toggle('is-active', active);

    if (active) item.setAttribute('aria-current', 'location');
    else item.removeAttribute('aria-current');
  });

  if (!link || !sectionNavTrack) return;

  const left = link.offsetLeft - ((sectionNavTrack.clientWidth - link.offsetWidth) / 2);
  sectionNavTrack.scrollTo({
    left: Math.max(0, left),
    behavior: reducedMotion.matches ? 'auto' : 'smooth',
  });
};

if (sectionTargets.length && 'IntersectionObserver' in window) {
  const sectionObserver = new IntersectionObserver(
    (entries) => {
      const visible = entries
        .filter((entry) => entry.isIntersecting)
        .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

      if (!visible) return;

      const match = sectionTargets.find(({ section }) => section === visible.target);
      if (match) setActiveSection(match.link);
    },
    {
      rootMargin: '-28% 0px -58% 0px',
      threshold: [0, 0.1, 0.25, 0.5],
    },
  );

  sectionTargets.forEach(({ section }) => sectionObserver.observe(section));
}

const revealSelectors = [
  '.section__header',
  '.editorial-split > *',
  '.founder-grid > *',
  '.founder-profile > *',
  '.mandate-grid > *',
  '.labs-intro-grid > *',
  '.labs-horizon-grid > *',
  '.closing-cta__inner > *',
  '.division-card',
  '.horizon-grid article',
  '.role-card',
  '.capability-card',
  '.continuum-grid article',
  '.research-card',
  '.focus-grid article',
  '.product-card',
  '.product-dossier__grid > *',
  '.future-list > div',
  '.timeline-list li',
  '.site-footer__statement',
  '.site-footer__grid > div',
].join(',');

const revealElements = [...document.querySelectorAll(revealSelectors)];

const revealAll = () => {
  revealElements.forEach((element) => {
    element.classList.remove('motion-reveal');
    element.classList.add('is-visible');
    element.style.removeProperty('--motion-delay');
  });
};

const initialiseReveals = () => {
  if (
    reducedMotion.matches
    || !('IntersectionObserver' in window)
    || window.location.hash
  ) {
    revealAll();
    return;
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;

        entry.target.classList.add('is-visible');
        observer.unobserve(entry.target);
      });
    },
    {
      rootMargin: '0px 0px -8% 0px',
      threshold: 0.12,
    },
  );

  revealElements.forEach((element, index) => {
    const rect = element.getBoundingClientRect();

    if (rect.top < window.innerHeight * 0.86) {
      element.classList.add('is-visible');
      return;
    }

    element.classList.add('motion-reveal');
    element.style.setProperty('--motion-delay', `${(index % 4) * 55}ms`);
    observer.observe(element);
  });
};

initialiseReveals();

reducedMotion.addEventListener?.('change', (event) => {
  if (event.matches) revealAll();
});

window.addEventListener('resize', () => {
  closeDesktopPanels(null, true);

  if (window.innerWidth > 1023 && toggle?.getAttribute('aria-expanded') === 'true') {
    setMenuState(false, { restoreFocus: false, immediate: true });
  }
}, { passive: true });
