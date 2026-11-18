"""Local-only: shrink PNGs by converting to a 256-colour palette with dithering (needs Pillow).
Usage: python3 tools/shrink-png.py public_html/assets/img/og/*.png"""
import os, sys
from PIL import Image

for path in sys.argv[1:]:
    before = os.path.getsize(path)
    im = Image.open(path).convert("RGB")
    im.quantize(colors=256, method=Image.Quantize.MEDIANCUT, dither=Image.Dither.FLOYDSTEINBERG).save(path, optimize=True)
    print(f"{os.path.basename(path)}: {before // 1024} KB -> {os.path.getsize(path) // 1024} KB")
