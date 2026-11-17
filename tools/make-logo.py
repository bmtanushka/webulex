"""Local-only: rebuilds the Webulex logo as clean SVG. Text is outlined to paths (OFL fonts).
Run: python3 tools/make-logo.py <font-dir> public_html/assets/brand
<font-dir> must hold rc900.ttf (Roboto Condensed 900) and inter600.ttf (Inter 600), both SIL OFL."""
import sys, os
from fontTools.ttLib import TTFont
from fontTools.pens.svgPathPen import SVGPathPen
from fontTools.pens.transformPen import TransformPen
from fontTools.pens.boundsPen import BoundsPen

FD = sys.argv[1]; OUT = sys.argv[2]

def text_path(fontfile, text, size, x, baseline, tracking=0.0):
    f = TTFont(fontfile); gs = f.getGlyphSet(); cmap = f.getBestCmap()
    upm = f['head'].unitsPerEm; s = size / upm
    hmtx = f['hmtx']; pen = SVGPathPen(gs, ntos=lambda v: f"{v:.2f}".rstrip('0').rstrip('.'))
    cx = x
    for ch in text:
        g = cmap[ord(ch)]
        tp = TransformPen(pen, (s, 0, 0, -s, cx, baseline))
        gs[g].draw(tp)
        cx += hmtx[g][0] * s + tracking
    return pen.getCommands(), cx - tracking

def glyph_bounds(fontfile, ch, size):
    f = TTFont(fontfile); gs = f.getGlyphSet(); g = f.getBestCmap()[ord(ch)]
    bp = BoundsPen(gs); gs[g].draw(bp); s = size / f['head'].unitsPerEm
    return [v * s for v in bp.bounds]

# ---- geometry (units) ----
W_PTS = [(9, 9), (28, 63), (46.5, 9), (65, 63), (84, 9)]
w_d = "M" + " L".join(f"{x} {y}" for x, y in W_PTS)
OUTER = 15.5; LINE = 1.35; GAP = 1.65
widths = []; w = OUTER; colour = "#fff"
while w > 0.6:
    widths.append((w, colour)); w -= 2 * (LINE if colour == "#fff" else GAP)
    colour = "#000" if colour == "#fff" else "#fff"

SIZE = 92; BASE = 66
word_d, word_end = text_path(f"{FD}/rc900.ttf", "ebulex", SIZE, 90, BASE, tracking=0.6)
dot_x = word_end + 9
UNDER_Y = 74
TAG = "TECHNOLOGY & ACCOUNTING SOLUTIONS (PVT) LTD"

def ring_list(line, gap):
    out = []; w = OUTER; c = "#fff"
    while w > 0.6:
        out.append((w, c)); w -= 2 * (line if c == "#fff" else gap); c = "#000" if c == "#fff" else "#fff"
    return out

def logo(dark=False, tagline=False, compact=False):
    navy = "#FFFFFF" if dark else "#303F9F"
    ink = "#C7CCE8" if dark else "#1F2937"
    rings = "".join(
        f'<path d="{w_d}" stroke="{c}" stroke-width="{w:.2f}"/>' for w, c in (ring_list(2.3, 2.3) if compact else widths))
    parts = []
    height = 80
    if tagline:
        # fit tagline to the underline span
        span = dot_x - 26
        tsize = 9.4
        _, raw_end = text_path(f"{FD}/inter600.ttf", TAG, tsize, 0, 0)
        tracking = (span - raw_end) / (len(TAG) - 1)
        tag_d, _ = text_path(f"{FD}/inter600.ttf", TAG, tsize, 26, 91, tracking)
        parts.append(f'<path d="{tag_d}" fill="{ink}"/>')
        height = 95
    width = dot_x + 8
    title = "Webulex Technology &amp; Accounting Solutions (PVT) Ltd" if tagline else "Webulex"
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {width:.1f} {height}" role="img" aria-labelledby="t">
<title id="t">{title}</title>
<defs>
<linearGradient id="wg" gradientUnits="userSpaceOnUse" x1="0" y1="72" x2="92" y2="0">
<stop offset="0" stop-color="#E25BF0"/><stop offset=".48" stop-color="#29B6F6"/><stop offset=".62" stop-color="#29B6F6"/><stop offset="1" stop-color="#D946EF"/>
</linearGradient>
<linearGradient id="gd" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#D2F5CF"/><stop offset="1" stop-color="#93D497"/></linearGradient>
<linearGradient id="bd" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#5CCBFA"/><stop offset="1" stop-color="#1E9FE0"/></linearGradient>
<mask id="wm" maskUnits="userSpaceOnUse" x="0" y="0" width="100" height="80">
<g fill="none" stroke-linecap="round" stroke-linejoin="round">{rings}</g>
</mask>
</defs>
<rect x="0" y="0" width="100" height="80" fill="url(#wg)" mask="url(#wm)"/>
<path d="{word_d}" fill="{navy}"/>
<path d="M26 {UNDER_Y} H{dot_x - 7:.1f} Q{dot_x:.1f} {UNDER_Y} {dot_x:.1f} {UNDER_Y - 7} V54" fill="none" stroke="#29B6F6" stroke-width="2.4" stroke-linecap="round"/>
<circle cx="{dot_x:.1f}" cy="30" r="5.6" fill="url(#gd)"/>
<circle cx="{dot_x:.1f}" cy="49.5" r="6.2" fill="url(#bd)"/>
{"".join(parts)}
</svg>
'''

def icon(bg=True):
    rings = "".join(f'<path d="{w_d}" stroke="{c}" stroke-width="{w:.2f}"/>' for w, c in widths[:4])
    return f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="-8 -18 109 109">
<defs><linearGradient id="wg" gradientUnits="userSpaceOnUse" x1="0" y1="72" x2="92" y2="0">
<stop offset="0" stop-color="#E25BF0"/><stop offset=".5" stop-color="#29B6F6"/><stop offset="1" stop-color="#D946EF"/></linearGradient></defs>
<rect x="-8" y="-18" width="109" height="109" rx="24" fill="#141A4A"/>
<path d="{w_d}" fill="none" stroke="url(#wg)" stroke-width="14" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
'''

os.makedirs(OUT, exist_ok=True)
for name, svg in {
    "webulex-logo.svg": logo(False, False, True),
    "webulex-logo-light.svg": logo(True, False, True),
    "webulex-logo-full.svg": logo(False, True),
    "webulex-logo-full-light.svg": logo(True, True),
    "icon.svg": icon(),
}.items():
    open(os.path.join(OUT, name), "w").write(svg)
print("rings", widths, "dot_x", dot_x)
