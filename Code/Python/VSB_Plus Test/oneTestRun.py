# -*- coding: utf-8 -*-
# @Date    : 2021-03-8 15:34:37
# @Author  : Xinyu Liu
import  unittest,time,os
from util import BSTestRunner
from config import description,reporttitle
from case.courseDB_test import TestCourseSearch
from case.semesterBuilder_test import TestSemesterBuilder
from case.login_test import TestLogin
from selenium import webdriver
path=os.getcwd()
case_path=path+'\\case'
def runOneTest():
    test_suit = unittest.TestSuite()
    test_suit.addTest(TestSemesterBuilder("test_prereq"))
   
    runner = unittest.TextTestRunner()
    runner.run(test_suit)


if __name__ == "__main__":
    runOneTest()
    
    # unittest.main()
    # driver = webdriver.Chrome()
    # driver.implicitly_wait(10)
    # driver.get("http://15.223.123.122/vsbp/Code/")
    # filename = 'aaa'
    # driver.get_screenshot_as_file(path+'/resultpang/%s.png'%filename)
    # driver.quit