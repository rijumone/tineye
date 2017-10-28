# open detail page
# capture name, age string; pass to OCR
# capture bio by scrolling; pass to OCR
# dump to db
# start capturing images; compare to last; stop when similar; max 6

# constants
img_tuple = (1013, 178, 375, 375)
img_tuple = (1013, 163, 375, 375)

from pyautogui import press
import time

time.sleep(3)		# 3 second warning, get your shit together

while True: 		# main loop
	press('up') 	# open detail page
