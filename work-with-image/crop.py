# http://matthiaseisen.com/pp/patterns/p0202/

from PIL import Image

img = Image.open("main.png")

print "generating cropped image from main image bottom"

width = img.size[0]
height = img.size[1]
img3 = img.crop(
    (
        width - 1080,
        height - 800,
        width,
        height - 200
    )
)
img3.save("main_cropped.png")

print "now generating cropped image from main image 1 top"

img = Image.open("main_1.png")

width = img.size[0]
height = img.size[1]
img3 = img.crop(
    (
        width - 1080,
        height - 1320,
        width,
        height - 720
    )
)
img3.save("main_cropped_1.png")
