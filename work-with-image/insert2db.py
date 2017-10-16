#!/usr/bin/python

import MySQLdb
import os

# Open database connection
db = MySQLdb.connect("localhost","root","root","tineye")

# Create a cursor object
cursor = db.cursor()


filePath = "/media/rijumone/BE02-5C63/Download/tmp/data/Delhi"

for directory in os.listdir(filePath):
	# int(directory) <= 1504385426 and 
	if int(directory) <= 1506082740 and os.path.isfile(filePath + "/" + directory + "/pytesseract_dump.txt"):
		f_name = ""
		l_name = ""
		age = ""
		sex = "woman"
		active = "1"
		bio = ""
		instagram = "NULL"
		spotify = "NULL"
		school_id = "NULL"
		work_id = "NULL"
		locality_id = "NULL"
		state_id = "1"
		city_id = "1"
		country_id = "1"
		with open(filePath + "/" + directory + "/pytesseract_dump.txt","r") as f:
			for line in f:
				# print line
				print directory
				name_age = line.split(", ")
				if len(name_age) > 1:
					name_age[1] = name_age[1].replace("\n","")
					# print name_age[1]
					if name_age[1].isdigit():
						print name_age
				# print name_age
	print "==============="

	# Prepare SQL query to INSERT a record into the database.
	sql = """INSERT INTO `profiles` (`id`, `first_name`, `last_name`, `age`, `sex`, `active`, `bio`, `instagram`, `spotify`, `school_id`, `	work_id`, `locality_id`, `state_id`, `city_id`, `country_id`, `created_at`, `updated_at`) VALUES ('1506082688', 'Mitali', '', '20', 'woman', '1', NULL, NULL, '1', NULL, NULL, NULL, '1', '1', '1', NULL, NULL);"""
	try:
	   # Execute the SQL command
	   # cursor.execute(sql)
	   # Commit your changes in the database
	   db.commit()
	except:
	   # Rollback in case there is any error
	   db.rollback()

# disconnect from server
db.close()
