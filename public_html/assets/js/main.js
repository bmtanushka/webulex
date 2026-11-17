// Webulex — progressive enhancement. The site works without this file.
import { initMegaMenus } from './nav.js';
import { initMobileNav } from './mobile-nav.js';
import { initRegion, initRegionTimes } from './region.js';
import { initReveal } from './reveal.js';
import { initCompare } from './compare.js';
import { initConsent } from './consent.js';
import { initForms, initOnlineStatus } from './forms.js';
import { initBooking } from './booking.js';
import { initChatbot } from './chatbot.js';

initConsent();
initMegaMenus();
initMobileNav();
initRegion();
initRegionTimes();
initReveal();
initCompare();
initForms();
initOnlineStatus();
initBooking();
initChatbot();
