# open detail page
# capture name, age string; pass to OCR
# capture bio by scrolling; pass to OCR
# dump to db
# start capturing images; compare to last; stop when similar; max 6

import pyautogui
import time
import Tkinter
import pickle
import MySQLdb
import os
import traceback
import re
import Image
import pytesseract

# constants
img_tpl = (1013, 163, 375, 375)		# 1920 x 1080
img_tpl = (804, 96, 375, 375)		# 999 x 619
ref_img_tpl = (1013, 163, 375, 567)	# 1920 x 1080
ref_img_tpl = (804, 125, 375, 385)	# 999 x 619
out_of_likes_img_tpl = (785, 338, 175, 30)	# 999 x 619
# name_age_tpl = (1013, 163, 375, 375)
# bio_drag_str_tpl = (1025, 665)
# bio_drag_end_tpl = (1200,823)
bio_tpl = (1185, 630)				# 1920 x 1080
bio_tpl = (985, 513)				# 999 x 619
sex = "man"

city_id = "2"
state_id = "2"
country_id = "1"

out_of_likes = False

local_dir = "/home/rijumone/Downloads/data/"
city = "Mumbai"

mysql_db_host = "localhost"
mysql_db_user = "root"
mysql_db_password = "root"
mysql_db_db_name = "tineye"

db = MySQLdb.connect(mysql_db_host, mysql_db_user, mysql_db_user, mysql_db_db_name)
cursor = db.cursor()
time.sleep(2)		# 3 second warning, get your shit together
root = Tkinter.Tk()
root.withdraw() # Hide the main window (optional)
# pyautogui.press('f11')	# enter full screen 
time.sleep(2.5)			# breath!
print("starting")

while not out_of_likes: 		# main loop
# for miu in range(3): 		# main loop
	# loop variables resetting
	work_id = "NULL"
	school_id = "NULL"
	work_school_id = "NULL"
	bio = ""
	occp_work_school = ""
	distance = "NULL"
	subdir = int(time.time())
	age = "0"

	working_path = local_dir + "/" + city + "/" + str(subdir) 
	
	if not os.path.exists(working_path):
	    os.makedirs(working_path)
	im = pyautogui.screenshot(region=ref_img_tpl)
	print("capturing reference image")
	im.save(working_path + "/ref.png")

	pyautogui.press('up') 	# open detail page
	time.sleep(3)			# first image takes exceptionally long to load
	# first let's get the images

	
	
	im = pyautogui.screenshot(region=img_tpl)
	print("capturing main image")
	im.save(working_path + "/main.png")
	
	main_img_size = os.path.getsize(working_path + "/main.png")	
	for n_img in range(5):
		print("images loop: " + str(n_img + 1))
		pyautogui.press('space') # load next image
		time.sleep(1.5)			# let the next image load

		im = pyautogui.screenshot(region=img_tpl)
		im.save(working_path + "/" + str(n_img + 1) + ".png")
		if abs(main_img_size - os.path.getsize(working_path + "/" + str(n_img + 1) + ".png")) < 10:
			# abs diff b/w main image and last captured image is less than 10 bytes
			os.remove(working_path + "/" + str(n_img + 1) + ".png") # delete the last image
			print("reached end of images, breaking out")
			break




	pyautogui.click(x=bio_tpl[0], y=bio_tpl[1]) # click on bio
	pyautogui.hotkey('ctrl', 'a')				# Ctrl + C
	pyautogui.hotkey('ctrl', 'c')				# Ctrl + A

	text_in_clipboard = root.clipboard_get()
	# text_in_clipboard = pickle.load(open("sample_txt.p"))
	# print(text_in_clipboard)
	# pickle.dump(text_in_clipboard,open("sample_txt.p","wb"))

	data_lst = text_in_clipboard.split("\n")
	print(data_lst)

	if False: # occupation, work, school scrapped for now
		# first check if work or school or both
		if len(text_in_clipboard.split("km. away")[0].split("\n")) >= 4 : # work and school both exist
			# fetch or insert work_id
			work_school_id = "NULL"
			work = data_lst[1].replace("'","&apos;")	
			sql = ("SELECT id,name FROM work_schools WHERE name = '%s' AND type = '%s' ;" %(work, "work"))
			cursor.execute(sql)
			results = cursor.fetchone()
			if results is not None:
				work_id = results[0]
				print("work found: " + results[1])
			else:
				sql = ("INSERT into work_schools (`name`,`type`) VALUES ('%s', '%s');" %(work, 'work'))	
				try:
					cursor.execute(sql)
			   		db.commit()
					work_id = cursor.lastrowid
				except:
				   # Rollback in case there is any error
				   print "EXCEPTION!"
				   print(traceback.format_exc())
				   db.rollback()
			# fetch or insert school_id
			school = data_lst[2].replace("'","&apos;")
			sql = ("SELECT id,name FROM work_schools WHERE name = '%s' AND type = '%s' ;" %(school, "school"))
			cursor.execute(sql)
			results = cursor.fetchone()
			if results is not None:
				school_id = results[0]
				print("school found: " + results[1])
			else:
				sql = ("INSERT into work_schools (`name`,`type`) VALUES ('%s', '%s');" %(school, 'school'))	
				try:
					cursor.execute(sql)
			   		db.commit()
					school_id = cursor.lastrowid
				except:
				   # Rollback in case there is any error
				   print "EXCEPTION!"
				   print(traceback.format_exc())
				   db.rollback()


		elif "km. away" not in data_lst[1]: # school and/or work info exists
			# fetch or insert work_school_id

			work_school_str = data_lst[1].replace("'","&apos;")
			sql = ("SELECT id,name FROM work_schools WHERE name = '%s';" %(work_school_str))
			cursor.execute(sql)
			results = cursor.fetchone()
			if results is not None:
				work_school_id = results[0]
				print("work/school found: " + results[1])
			else:
				sql = ("INSERT into work_schools (`name`) VALUES ('%s');" %(work_school_str))
				try:
					cursor.execute(sql)
			   		db.commit()
					work_school_id = cursor.lastrowid
				except:
				   # Rollback in case there is any error
				   print "EXCEPTION!"
				   print(traceback.format_exc())
				   db.rollback()

	name = data_lst[0].split(", ")[0].replace("'","&apos;")
	if len(text_in_clipboard.split("Profile menu")[0].split("\n")) >= 2:
		occp_work_school = " | ".join(text_in_clipboard.split("Profile menu")[0].split("\n")[1:]).replace("'","&apos;")
	if len(data_lst[0].split(", ")) >= 2: # age exists 
		age = data_lst[0].split(", ")[1]
		# 
	if len(text_in_clipboard.split(" km. away")) >= 2: # distance exists
		distance = text_in_clipboard.split(" km. away")[0].split("\n")[-1]
	if len(text_in_clipboard.split("Profile menu")) >= 2: # bio exists
		bio = re.sub(r'[^\x00-\x7F]+',' ', text_in_clipboard.split("Profile menu")[1].replace("\n","<br />").replace("'","&apos;"))
	# re.sub(r'[^\x00-\x7F]+',' ', text)
	print(str(subdir))
	print(name)
	print(age)
	print(sex)
	print(bio)
	print(distance)

	# main "profiles" insert
	sql = ("INSERT into profiles (`id`,`first_name`,`last_name`,`age`,`sex`,`active`,`bio`,`distance`,`occp_work_school`,`work_school_id`,`school_id`,`work_id`,`city_id`,`state_id`,`country_id`) VALUES (%s, '%s', '', %s, '%s', 1, '%s', %s, '%s', %s, %s, %s, %s, %s, %s);" %(str(subdir), name, str(age), sex, bio, distance, occp_work_school, str(work_school_id), str(school_id), str(work_id), city_id, state_id, country_id))

	try:
		cursor.execute(sql)
		db.commit()
		print("data inserted!")
	except:
	   # Rollback in case there is any error
	   print "EXCEPTION!"
	   print(traceback.format_exc())
	   db.rollback()


	print("last insert id: " + str(cursor.lastrowid))
	if sex == "man":
		pyautogui.press('left') 	# nope
	else:
		pyautogui.press('right') 	# like
	time.sleep(1.5)

	# check if out of likes
	im = pyautogui.screenshot(region=out_of_likes_img_tpl)
	im.save("out_of_likes_test.png")
	if pytesseract.image_to_string(Image.open("out_of_likes_test.png")):
		out_of_likes = True
		os.remove("out_of_likes_test.png")	

# pyautogui.press('f11')	# exit full screen 
