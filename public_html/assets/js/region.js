// Guesses the visitor's region from the browser time zone, only to highlight the matching chip.
// Never redirects. The contact form uses the same guess to preselect the country (Phase 5).
export function guessRegion() {
  let tz = '';
  try {
    tz = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
  } catch {
    return null;
  }
  if (tz === 'Europe/London' || tz === 'Europe/Belfast') return 'uk';
  if (tz === 'Asia/Singapore') return 'sg';
  if (tz.startsWith('Australia/')) return 'au';
  if (tz.startsWith('America/') && /New_York|Chicago|Denver|Los_Angeles|Phoenix|Anchorage|Detroit|Indiana|Kentucky|Boise|Juneau|Adak|Menominee|Nome|Sitka|Yakutat|North_Dakota/.test(tz)) return 'us';
  if (tz === 'Pacific/Honolulu') return 'us';
  return null;
}

export function initRegion() {
  const region = guessRegion();
  if (!region) return;
  document.querySelectorAll(`[data-region="${region}"]`).forEach((el) => el.classList.add('is-local'));
}

// Shows the current local time in each region tile, e.g. "London: 09:41 now".
export function initRegionTimes() {
  const els = document.querySelectorAll('[data-tz]');
  if (!els.length) return;
  const render = () => {
    els.forEach((el) => {
      try {
        const t = new Intl.DateTimeFormat('en-GB', { timeZone: el.dataset.tz, hour: '2-digit', minute: '2-digit', weekday: 'short' }).format(new Date());
        el.textContent = `${el.dataset.tzLabel}: ${t} now`;
      } catch {
        /* unsupported time zone: leave empty */
      }
    });
  };
  render();
  setInterval(render, 30000);
}
