/**
 * Original Webulex illustrations, drawn in code (owned outright, no licence).
 * Local-only tool. Run: node tools/draw-illustrations.mjs
 * Writes SVGs to public_html/assets/illustrations/ using the names in BRIEF §6.6.
 * Every gradient id is prefixed per file so inlined SVGs never collide.
 */
import fs from "node:fs";
import path from "node:path";

const OUT = path.resolve(import.meta.dirname, "../public_html/assets/illustrations");

const C = {
  navy900: "#141A4A",
  navy700: "#232E7A",
  navy: "#303F9F",
  cyan: "#29B6F6",
  cyan700: "#0277BD",
  cyan100: "#E9F7FE",
  cyan200: "#C6ECFD",
  magenta: "#D946EF",
  mag100: "#FBEAFE",
  surface: "#F6F7FC",
  line: "#E3E6F3",
  line2: "#CDD3EC",
  white: "#FFFFFF",
  green: "#5FC27A",
  green100: "#E4F6E7",
  yellow: "#F5B400",
};

/* ---------- primitives ---------- */
const n = (v) => +v.toFixed(2);
const rect = (x, y, w, h, fill, r = 0, extra = "") =>
  `<rect x="${n(x)}" y="${n(y)}" width="${n(w)}" height="${n(h)}" rx="${r}" fill="${fill}"${extra}/>`;
const bar = (x, y, w, h = 6, fill = C.line) => rect(x, y, w, h, fill, h / 2);
const circle = (cx, cy, r, fill, extra = "") => `<circle cx="${n(cx)}" cy="${n(cy)}" r="${n(r)}" fill="${fill}"${extra}/>`;
/** Card with a soft navy-tinted drop shadow. */
const card = (x, y, w, h, { r = 12, fill = C.white, shadow = 0.1, dy = 8, stroke } = {}) =>
  (shadow ? rect(x + 2, y + dy, w - 4, h, C.navy900, r, ` opacity="${shadow}"`) : "") +
  rect(x, y, w, h, fill, r, stroke ? ` stroke="${stroke}" stroke-width="1.5"` : "");
const star = (cx, cy, r, fill) => {
  const pts = [];
  for (let i = 0; i < 10; i++) {
    const a = (Math.PI / 5) * i - Math.PI / 2;
    const rr = i % 2 ? r * 0.45 : r;
    pts.push(`${n(cx + rr * Math.cos(a))},${n(cy + rr * Math.sin(a))}`);
  }
  return `<polygon points="${pts.join(" ")}" fill="${fill}"/>`;
};
const sparkle = (cx, cy, r, fill) =>
  `<path d="M${cx} ${cy - r}Q${cx} ${cy} ${cx + r} ${cy}Q${cx} ${cy} ${cx} ${cy + r}Q${cx} ${cy} ${cx - r} ${cy}Q${cx} ${cy} ${cx} ${cy - r}Z" fill="${fill}"/>`;
const heart = (cx, cy, s, fill) =>
  `<path transform="translate(${cx - 12 * s} ${cy - 11 * s}) scale(${s})" d="M12 21s-7.5-4.6-9.6-9.2C.9 8.4 3 4.5 6.7 4.5c2.2 0 3.7 1.2 5.3 3.1 1.6-1.9 3.1-3.1 5.3-3.1 3.7 0 5.8 3.9 4.3 7.3C19.5 16.4 12 21 12 21Z" fill="${fill}"/>`;
const check = (cx, cy, s, stroke, w = 2.4) =>
  `<path d="M${cx - 5 * s} ${cy}l${3.5 * s} ${3.5 * s} ${6.5 * s} -${7 * s}" fill="none" stroke="${stroke}" stroke-width="${w}" stroke-linecap="round" stroke-linejoin="round"/>`;
const pin = (cx, cy, s, fill, inner = C.white) =>
  `<path transform="translate(${cx - 12 * s} ${cy - 30 * s}) scale(${s})" d="M12 30S0 18.6 0 11.5C0 5.1 5.4 0 12 0s12 5.1 12 11.5C24 18.6 12 30 12 30Z" fill="${fill}"/>` +
  circle(cx, cy - 18.5 * s, 4.6 * s, inner);
const envelope = (x, y, w, h, stroke, fill = "none") =>
  rect(x, y, w, h, fill, 3, ` stroke="${stroke}" stroke-width="2.2"`) +
  `<path d="M${x + 1} ${y + 2}L${x + w / 2} ${y + h * 0.58}L${x + w - 1} ${y + 2}" fill="none" stroke="${stroke}" stroke-width="2.2" stroke-linejoin="round"/>`;
const dots3 = (x, y) => circle(x, y, 3.2, "#F7A8D6") + circle(x + 11, y, 3.2, "#FFD27A") + circle(x + 22, y, 3.2, "#A8E3B6");
/** Browser window frame. */
const browser = (x, y, w, h, { shadow = 0.12, url = true } = {}) =>
  card(x, y, w, h, { r: 14, shadow }) +
  `<path d="M${x} ${y + 14}a14 14 0 0 1 14-14h${w - 28}a14 14 0 0 1 14 14v14H${x}Z" fill="${C.surface}"/>` +
  dots3(x + 15, y + 14) +
  (url ? bar(x + 54, y + 8, Math.min(180, w - 80), 12, C.white) : "");
/** Isometric cube (top, left, right faces). */
const cube = (cx, cy, s, top, left, right) => {
  const h = s * 0.5;
  return (
    `<path d="M${cx} ${cy - h}L${cx + s} ${cy}L${cx} ${cy + h}L${cx - s} ${cy}Z" fill="${top}"/>` +
    `<path d="M${cx - s} ${cy}L${cx} ${cy + h}L${cx} ${cy + h + s}L${cx - s} ${cy + s}Z" fill="${left}"/>` +
    `<path d="M${cx + s} ${cy}L${cx} ${cy + h}L${cx} ${cy + h + s}L${cx + s} ${cy + s}Z" fill="${right}"/>`
  );
};
const gear = (cx, cy, r, fill, hole = C.white) => {
  const teeth = [];
  for (let i = 0; i < 8; i++) {
    const a = (i * 45 * Math.PI) / 180;
    teeth.push(
      `<rect x="${n(cx - r * 0.22)}" y="${n(cy - r * 1.28)}" width="${n(r * 0.44)}" height="${n(r * 0.5)}" rx="${n(r * 0.1)}" fill="${fill}" transform="rotate(${i * 45} ${cx} ${cy})"/>`,
    );
    void a;
  }
  return teeth.join("") + circle(cx, cy, r, fill) + circle(cx, cy, r * 0.42, hole);
};
const svg = (id, w, h, body, defs = "") =>
  `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${w} ${h}" width="${w}" height="${h}" fill="none">` +
  (defs ? `<defs>${defs.replaceAll("§", id)}</defs>` : "") +
  body.replaceAll("§", id) +
  `</svg>\n`;
const lin = (id, x1, y1, x2, y2, stops) =>
  `<linearGradient id="§${id}" x1="${x1}" y1="${y1}" x2="${x2}" y2="${y2}">` +
  stops.map(([o, c, op = 1]) => `<stop offset="${o}" stop-color="${c}" stop-opacity="${op}"/>`).join("") +
  `</linearGradient>`;
const brandGrad = (id) => lin(id, 0, 0, 1, 1, [[0, C.navy], [0.6, C.cyan], [1, C.magenta]]);
const softBlob = (cx, cy, rx, ry, fill = C.cyan100) => `<ellipse cx="${cx}" cy="${cy}" rx="${rx}" ry="${ry}" fill="${fill}"/>`;

/* ================= HERO: building a website that books customers ================= */
function heroTeam() {
  const defs =
    brandGrad("g") +
    lin("img", 0, 0, 1, 1, [[0, C.cyan], [1, C.navy]]) +
    lin("btn", 0, 0, 1, 0, [[0, C.navy], [1, "#4F5FD1"]]);
  let b = "";
  // Main browser
  b += browser(20, 26, 344, 254, { shadow: 0.35 });
  // nav
  b += rect(36, 68, 18, 18, "url(#§g)", 5);
  b += bar(60, 74, 44, 6, C.navy);
  b += bar(186, 75, 24, 5, C.line2) + bar(216, 75, 24, 5, C.line2) + bar(246, 75, 24, 5, C.line2);
  b += rect(284, 67, 64, 20, C.cyan, 10) + bar(296, 74, 40, 6, C.white);
  // hero copy
  b += bar(36, 104, 150, 13, C.navy) + bar(36, 123, 112, 13, C.navy);
  b += bar(36, 148, 140, 6, C.line2) + bar(36, 160, 124, 6, C.line2) + bar(36, 172, 96, 6, C.line2);
  b += rect(36, 190, 78, 24, "url(#§btn)", 12) + bar(50, 199, 42, 6, C.white) + `<path d="M98 198.5l4 3.5-4 3.5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>`;
  b += rect(120, 190, 62, 24, C.white, 12, ` stroke="${C.line2}" stroke-width="1.5"`) + bar(134, 199, 34, 6, C.line2);
  // hero image
  b += rect(200, 100, 148, 116, "url(#§img)", 12);
  b += circle(312, 128, 13, C.white, ' opacity=".9"');
  b += `<path d="M200 186l34-30 30 24 22-16 62 42v2a12 12 0 0 1-12 12H212a12 12 0 0 1-12-12Z" fill="#fff" opacity=".28"/>`;
  b += `<path d="M200 200l42-24 40 22 26-12 40 18v8a12 12 0 0 1-12 12H212a12 12 0 0 1-12-12Z" fill="#fff" opacity=".5"/>`;
  // service cards
  for (const [i, col] of [[0, C.cyan], [1, C.magenta], [2, C.navy]]) {
    const x = 36 + i * 106;
    b += rect(x, 230, 96, 38, C.surface, 9);
    b += circle(x + 18, 249, 10, col === C.navy ? "#E6E9F7" : col === C.cyan ? C.cyan100 : C.mag100) + circle(x + 18, 249, 4, col);
    b += bar(x + 34, 241, 48, 6, C.navy) + bar(x + 34, 252, 38, 5, C.line2);
  }
  // cursor clicking the CTA
  b += circle(104, 210, 13, C.cyan, ' opacity=".25"') + circle(104, 210, 7, C.cyan, ' opacity=".35"');
  b += `<path d="M104 208l2 17 4.6-5.2 6.9.9Z" fill="${C.navy900}" stroke="#fff" stroke-width="1.6" stroke-linejoin="round"/>`;

  // Phone with booking calendar
  b += rect(334, 112, 118, 222, C.navy900, 22, ' opacity=".35" transform="translate(4 10)"');
  b += rect(334, 112, 118, 222, C.navy900, 22);
  b += rect(342, 124, 102, 198, C.white, 15);
  b += bar(374, 117, 38, 4, "#2E3770");
  b += bar(354, 138, 46, 7, C.navy);
  b += `<path d="M418 138l-3 3.5 3 3.5M428 138l3 3.5-3 3.5" stroke="${C.line2}" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>`;
  for (let c = 0; c < 7; c++) b += bar(355 + c * 12.4 - 2, 156, 6, 3, C.line2);
  for (let r = 0; r < 4; r++)
    for (let c = 0; c < 7; c++) {
      const cx = 356 + c * 12.4, cy = 170 + r * 14;
      if (r === 1 && c === 3) b += circle(cx, cy, 6.2, C.cyan) + circle(cx, cy, 2, C.white);
      else if ((r === 2 && c === 1) || (r === 0 && c === 5)) b += circle(cx, cy, 3.4, C.magenta, ' opacity=".55"');
      else b += circle(cx, cy, 2.6, C.line);
    }
  b += rect(354, 232, 78, 18, C.cyan100, 9, ` stroke="${C.cyan}" stroke-width="1.5"`) + bar(364, 238, 34, 6, C.cyan700) + check(420, 241, 0.7, C.cyan700, 2);
  b += rect(354, 256, 78, 18, C.white, 9, ` stroke="${C.line}" stroke-width="1.5"`) + bar(364, 262, 30, 6, C.line2);
  b += rect(354, 288, 78, 22, "url(#§btn)", 11) + bar(374, 296, 38, 6, C.white);

  // code chip + sparkle
  b += card(352, 34, 72, 40, { r: 12, fill: C.navy700, shadow: 0.3 });
  b += `<path d="M372 47l-7 7 7 7M404 47l7 7-7 7M392 44l-8 20" stroke="${C.cyan}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>`;
  b += sparkle(448, 96, 9, C.magenta) + sparkle(22, 300, 7, C.cyan) + sparkle(462, 58, 5, "#fff");
  return svg("ht", 480, 360, b, defs);
}

/* ================= BUILD: code becomes a website ================= */
function build() {
  const defs = brandGrad("g") + lin("img", 0, 0, 1, 1, [[0, C.cyan], [1, C.navy]]);
  let b = softBlob(250, 190, 210, 150);
  // code editor
  b += card(30, 40, 236, 176, { r: 14, fill: C.navy900, shadow: 0.18 });
  b += dots3(46, 56);
  const code = [
    [0, 50, C.magenta], [0, 80, C.cyan],
    [1, 64, "#8E9BE0"], [2, 92, C.green], [2, 54, C.cyan],
    [1, 40, "#8E9BE0"], [1, 102, C.yellow], [2, 70, C.cyan], [0, 36, C.magenta],
  ];
  code.forEach(([indent, w, col], i) => {
    const y = 76 + i * 14.5;
    b += bar(44, y, 10, 5, "#3A4380");
    b += bar(64 + indent * 16, y, w, 6, col);
    if (i % 3 === 1) b += bar(70 + indent * 16 + w, y, 30, 6, "#4A5596");
  });
  // browser preview
  b += browser(206, 100, 248, 200, { shadow: 0.14 });
  b += rect(222, 142, 18, 14, "url(#§g)", 4) + bar(246, 146, 40, 6, C.navy) + rect(398, 140, 42, 16, C.cyan, 8);
  b += rect(222, 168, 216, 62, "url(#§img)", 10);
  b += bar(236, 184, 96, 10, C.white) + bar(236, 200, 70, 6, "#ffffffb3") + rect(236, 212, 44, 12, C.magenta, 6);
  b += `<path d="M352 230l26-22 22 14 16-10 22 18Z" fill="#fff" opacity=".35"/>`;
  for (let i = 0; i < 3; i++) {
    const x = 222 + i * 74;
    b += rect(x, 242, 66, 44, C.surface, 8) + circle(x + 13, 256, 7, i === 1 ? C.mag100 : C.cyan100) + circle(x + 13, 256, 3, i === 1 ? C.magenta : C.cyan);
    b += bar(x + 10, 270, 46, 5, C.line2);
  }
  // building blocks
  b += cube(96, 292, 30, "#5C6BD0", C.navy, C.navy700);
  b += cube(150, 300, 22, "#7DD3FC", C.cyan, C.cyan700);
  b += cube(110, 254, 22, "#F0A6F8", C.magenta, "#A21CAF");
  // gear + secure badge
  b += gear(430, 66, 16, C.cyan) + gear(400, 46, 9, C.navy);
  b += circle(446, 282, 20, C.green) + `<rect x="437" y="281" width="18" height="13" rx="3" fill="#fff"/><path d="M441 281v-4a5 5 0 0 1 10 0v4" stroke="#fff" stroke-width="2.6"/>`;
  b += sparkle(300, 64, 8, C.magenta) + sparkle(20, 250, 6, C.cyan);
  return svg("bd", 480, 360, b, defs);
}

/* ================= GROW: found on Google, Maps and AI search ================= */
function grow() {
  const defs = brandGrad("g") + lin("bar", 0, 1, 0, 0, [[0, C.cyan], [1, C.navy]]);
  let b = softBlob(240, 200, 220, 150);
  // search box
  b += card(36, 34, 300, 44, { r: 22, shadow: 0.12, dy: 6 });
  b += circle(64, 56, 8, "none", ` stroke="${C.navy}" stroke-width="2.6"`) + `<path d="M70 62l6 6" stroke="${C.navy}" stroke-width="2.6" stroke-linecap="round"/>`;
  b += bar(88, 52, 132, 8, C.navy) + rect(226, 48, 2, 16, C.cyan, 1);
  b += circle(312, 56, 11, C.cyan) + `<path d="M308 56h8M312 52v8" stroke="#fff" stroke-width="0"/>` + sparkle(312, 56, 6, C.white);
  // results list
  b += card(36, 92, 262, 214, { r: 14, shadow: 0.12 });
  b += rect(48, 104, 238, 70, C.cyan100, 10) + rect(48, 104, 4, 70, C.cyan, 2);
  b += circle(76, 126, 12, C.magenta) + `<path d="M74 120l4-2.4v16" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>`;
  b += bar(98, 116, 120, 9, C.navy) + bar(98, 131, 80, 5, C.green);
  for (let i = 0; i < 5; i++) b += star(104 + i * 13, 151, 5.5, C.yellow);
  b += bar(172, 148, 60, 6, C.line2) + bar(98, 162, 160, 5, C.line2);
  for (let i = 0; i < 2; i++) {
    const y = 190 + i * 56;
    b += circle(76, y + 12, 10, C.surface);
    b += bar(98, y + 4, 110, 8, "#A4ADD9") + bar(98, y + 18, 70, 5, C.line2) + bar(98, y + 30, 150, 5, C.line) + bar(98, y + 40, 120, 5, C.line);
  }
  // map card
  b += card(284, 150, 168, 150, { r: 14, shadow: 0.14 });
  b += `<clipPath id="§map"><rect x="294" y="160" width="148" height="130" rx="9"/></clipPath>`;
  b += `<g clip-path="url(#§map)">` + rect(294, 160, 148, 130, "#EEF1FA") +
    `<path d="M294 210c40-6 70 10 148-14v-36H294Z" fill="${C.cyan200}" opacity=".7"/>` +
    rect(380, 236, 50, 40, C.green100, 8) +
    `<path d="M294 248h148M348 160v130M294 278l70-50 78 30" stroke="#fff" stroke-width="7"/>` +
    `</g>`;
  b += pin(318, 262, 0.62, C.navy) + pin(410, 226, 0.62, C.navy) + pin(362, 238, 1.05, C.magenta);
  b += circle(362, 240, 14, C.magenta, ' opacity=".18"');
  // growth chart
  b += card(352, 30, 100, 104, { r: 14, shadow: 0.12 });
  [26, 38, 34, 52, 66].forEach((h, i) => (b += rect(366 + i * 15, 118 - h, 10, h, i === 4 ? "url(#§bar)" : C.cyan100, 3)));
  b += `<path d="M368 92l18-12 14 6 16-18 20-14" stroke="${C.magenta}" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>`;
  b += `<path d="M428 47l9 1-1 9" stroke="${C.magenta}" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>`;
  // AI answer bubble (AIEO)
  b += card(14, 266, 150, 70, { r: 16, fill: C.navy900, shadow: 0.22 });
  b += circle(40, 292, 13, C.navy700) + sparkle(40, 292, 8, C.magenta) + sparkle(46, 285, 3.5, C.cyan);
  b += bar(62, 284, 82, 6, "#C7CCE8") + bar(62, 296, 64, 6, "#6B76B8") + bar(28, 316, 100, 6, C.cyan);
  b += `<path d="M44 336l-6 12 16-12" fill="${C.navy900}"/>`;
  return svg("gr", 480, 360, b, defs);
}

/* ================= PROMOTE: social, ads, video, email ================= */
function promote() {
  const defs =
    lin("post", 0, 0, 1, 1, [[0, C.magenta], [0.55, "#7C6BF0"], [1, C.cyan]]) +
    lin("ad", 0, 0, 1, 1, [[0, C.cyan], [1, C.navy]]) +
    lin("bar", 0, 1, 0, 0, [[0, C.magenta], [1, "#F0A6F8"]]);
  let b = softBlob(240, 190, 215, 150, C.mag100);
  // megaphone
  b += `<g transform="rotate(-14 90 170)">` +
    rect(40, 150, 28, 40, C.navy700, 6) +
    `<path d="M66 150l62-30v100l-62-30Z" fill="${C.navy}"/>` +
    rect(124, 114, 14, 112, C.cyan, 7) +
    rect(52, 188, 14, 30, C.navy700, 5) +
    `</g>`;
  b += `<path d="M150 112c10 8 14 20 12 32M164 96c16 14 22 34 18 54" stroke="${C.magenta}" stroke-width="3.2" stroke-linecap="round"/>`;
  // phone with social post
  b += rect(168, 26, 150, 304, C.navy900, 26, ' opacity=".2" transform="translate(5 10)"');
  b += rect(168, 26, 150, 304, C.navy900, 26);
  b += rect(177, 40, 132, 278, C.white, 18);
  b += bar(222, 31, 42, 5, "#2E3770");
  b += circle(196, 62, 10, "url(#§ad)") + bar(212, 56, 56, 6, C.navy) + bar(212, 66, 34, 5, C.line2);
  b += rect(186, 80, 114, 114, "url(#§post)", 10);
  b += circle(270, 108, 14, "#fff", ' opacity=".85"');
  b += `<path d="M186 172l30-28 26 20 18-12 40 32v0a10 10 0 0 1-10 10H196a10 10 0 0 1-10-10Z" fill="#fff" opacity=".35"/>`;
  b += heart(198, 212, 0.62, C.magenta);
  b += `<path d="M216 205h14a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3h-8l-5 4v-4h-1a3 3 0 0 1-3-3v-8a3 3 0 0 1 3-3Z" stroke="${C.navy}" stroke-width="2" stroke-linejoin="round"/>`;
  b += `<path d="M244 214l14-8-3 16-4-6Z" stroke="${C.navy}" stroke-width="2" stroke-linejoin="round"/>`;
  b += bar(188, 232, 70, 6, C.navy) + bar(188, 244, 104, 5, C.line2) + bar(188, 254, 88, 5, C.line2);
  b += circle(196, 284, 10, C.cyan100) + bar(212, 278, 60, 6, C.line2) + bar(212, 288, 40, 5, C.line);
  // floating like bubble
  b += card(286, 196, 64, 30, { r: 15, fill: C.magenta, shadow: 0.2, dy: 6 }) + heart(303, 211, 0.55, "#fff") + bar(316, 208, 24, 6, "#fff");
  // ad card
  b += card(338, 36, 124, 136, { r: 14, shadow: 0.13 });
  b += rect(350, 48, 100, 58, "url(#§ad)", 8) + rect(356, 54, 24, 13, C.yellow, 4) + bar(361, 58, 14, 5, C.navy900);
  b += `<path d="M350 98l26-20 20 14 18-10 36 22v2a4 4 0 0 1-4 4h-92a4 4 0 0 1-4-4Z" fill="#fff" opacity=".35"/>`;
  b += bar(350, 116, 80, 7, C.navy) + bar(350, 129, 96, 5, C.line2);
  b += rect(350, 142, 54, 18, C.cyan, 9) + bar(360, 148, 34, 6, "#fff");
  // results bars
  b += card(346, 196, 112, 110, { r: 14, shadow: 0.13 });
  b += bar(358, 210, 50, 6, C.navy);
  [22, 34, 30, 48, 62].forEach((h, i) => (b += rect(360 + i * 18, 292 - h, 11, h, i > 2 ? "url(#§bar)" : C.mag100, 3)));
  // video + email bubbles
  b += circle(126, 270, 26, C.white, ` stroke="${C.line}" stroke-width="1.5"`) + rect(110, 259, 32, 22, C.magenta, 6) + `<path d="M122 264v12l9-6Z" fill="#fff"/>`;
  b += circle(70, 296, 22, C.cyan) + envelope(58, 288, 24, 17, "#fff");
  b += sparkle(332, 330, 7, C.cyan) + sparkle(40, 64, 8, C.magenta) + star(150, 52, 7, C.yellow);
  return svg("pr", 480, 360, b, defs);
}

/* ================= AUTOMATE: workflows, AI, CRM, messaging ================= */
function automate() {
  const defs = brandGrad("g") + lin("ai", 0, 0, 1, 1, [[0, C.navy700], [1, C.navy900]]);
  let b = softBlob(250, 190, 220, 150);
  const node = (x, y, inner, { dark = false, accent = C.cyan } = {}) =>
    card(x, y, 64, 64, { r: 16, fill: dark ? "url(#§ai)" : C.white, shadow: 0.14 }) +
    rect(x, y + 60, 64, 4, accent, 2, ' opacity="0"') + inner;
  const link = (d, col = C.cyan) =>
    `<path d="${d}" stroke="${col}" stroke-width="2.6" stroke-dasharray="6 6" stroke-linecap="round"/>`;
  // links first (behind)
  b += link("M100 182C130 182 132 120 158 120");
  b += link("M222 120C252 120 252 182 282 182", C.magenta);
  b += link("M100 182C130 182 132 250 158 250");
  b += link("M346 182C370 182 370 100 392 100");
  b += link("M346 182C370 182 370 262 392 262");
  b += link("M222 250C252 250 252 182 282 182");
  // travelling pulses
  for (const [x, y, c] of [[129, 152, C.cyan], [252, 151, C.magenta], [369, 141, C.cyan], [369, 224, C.cyan]]) b += circle(x, y, 5, c);
  // 1 form
  b += node(36, 150, rect(52, 166, 32, 32, C.cyan100, 6) + bar(57, 172, 18, 4, C.cyan700) + bar(57, 180, 22, 4, C.line2) + bar(57, 188, 14, 4, C.line2));
  // 2 AI
  b += node(158, 88, sparkle(190, 120, 15, C.magenta) + sparkle(204, 104, 6, C.cyan), { dark: true });
  // 3 booking
  b += node(158, 218, rect(174, 236, 32, 28, C.white, 5, ` stroke="${C.navy}" stroke-width="2.2"`) + rect(174, 236, 32, 8, C.navy, 3) + circle(184, 252, 2.5, C.line2) + circle(196, 252, 2.5, C.magenta) + circle(184, 259, 2.5, C.line2) + bar(179, 231, 3, 9, C.navy) + bar(198, 231, 3, 9, C.navy));
  // 4 CRM (database + people)
  b += node(282, 150,
    `<ellipse cx="314" cy="170" rx="14" ry="5" fill="${C.navy}"/>` +
    `<path d="M300 170v20c0 2.8 6.3 5 14 5s14-2.2 14-5v-20" fill="${C.navy700}"/>` +
    `<path d="M300 180c0 2.8 6.3 5 14 5s14-2.2 14-5" stroke="#8E9BE0" stroke-width="1.6"/>` +
    circle(330, 194, 7, C.cyan, ' stroke="#fff" stroke-width="2"'));
  // 5 WhatsApp-style chat
  b += node(392, 68, `<path d="M410 84h28a6 6 0 0 1 6 6v14a6 6 0 0 1-6 6h-18l-8 7v-7h-2a6 6 0 0 1-6-6V90a6 6 0 0 1 6-6Z" fill="${C.green}"/>` + check(424, 97, 0.8, "#fff", 2.4));
  // 6 email
  b += node(392, 230, envelope(408, 250, 32, 23, C.cyan, C.cyan100));
  // chatbot card
  b += card(26, 36, 120, 82, { r: 16, shadow: 0.13 });
  b += rect(42, 54, 34, 28, C.navy, 9) + circle(52, 68, 3.6, C.cyan) + circle(66, 68, 3.6, C.cyan) + bar(54, 75, 10, 2.4, "#8E9BE0");
  b += bar(57.5, 44, 3, 10, C.navy) + circle(59, 43, 4, C.magenta);
  b += rect(84, 54, 50, 14, C.cyan100, 7) + rect(84, 72, 38, 14, C.surface, 7);
  b += bar(40, 96, 94, 8, C.line);
  // call agent card
  b += card(26, 268, 136, 62, { r: 16, fill: C.navy900, shadow: 0.2 });
  b += circle(54, 299, 16, C.cyan) + `<path transform="translate(44 289) scale(.85)" d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.4 1.8.7 2.7a2 2 0 0 1-.5 2.1L8 9.8a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.7.7a2 2 0 0 1 1.7 2Z" fill="#fff"/>`;
  [10, 18, 26, 14, 22, 8, 16].forEach((h, i) => (b += rect(80 + i * 9, 299 - h / 2, 4.5, h, i % 2 ? C.magenta : "#8E9BE0", 2.25)));
  b += sparkle(462, 186, 8, C.magenta) + sparkle(250, 36, 7, C.cyan) + gear(250, 318, 10, C.line2, "#fff");
  return svg("au", 480, 360, b, defs);
}

fs.mkdirSync(OUT, { recursive: true });
const files = { "hero-team": heroTeam(), build: build(), grow: grow(), promote: promote(), automate: automate() };
for (const [name, content] of Object.entries(files)) {
  fs.writeFileSync(path.join(OUT, `${name}.svg`), content);
  console.log(`${name}.svg  ${(content.length / 1024).toFixed(1)} KB`);
}
