import yaml,os, time
from common.drag_drog import drag_and_drop
path=os.getcwd()
from selenium.webdriver.support.select import Select
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.common.by import By
from util import log

class AcademicBuilder:#封装
    def __init__(self,driver):#
        self.driver=driver
        self.logs = log.log_message()
        self.file=open(path+"\\data\\page_data.yaml", "r",encoding= "utf-8")
        self.data=yaml.load(self.file, Loader=yaml.FullLoader)
        self.file.close()

        #Load the datas
        self.credit = None
        self.alertMes = None
        self.showNavBar = self.data['semesterBuilder'].get('showNavBar')
        self.semsterPage=self.data['semesterBuilder'].get('semsterPage')
        self.academicLink=self.data['academicBuilder'].get('academicLink')

        # Get to the semester builder page
        self.driver.get(self.academicLink)

    def dragIn(self, courses, termNum):
        self.driver.maximize_window()
        time.sleep(1)
        for index, course in enumerate(courses):
            source = self.driver.find_element_by_xpath("//p[contains(text(),'"+ course +"')]/..")
            dests = self.driver.find_elements_by_css_selector("#term"+str(termNum) + ">div")
        
            # print(source.text,dests[0].text)
            # print(dests[1].get_attribute('name'))

            # Max course postion is 5 that start at 1
            loc = index % 5 + 1
            drag_and_drop(self.driver, source, dests[loc])
            
            time.sleep(1)
            try:
                alert = self.driver.switch_to_alert()
                self.alertMes = alert.text 
                alert.accept()
            except:
                pass
            finally:
                self.credit = self.driver.find_element_by_id("show_credits").text


    def getResult(self, suc):
        return self.credit if suc=='1' else self.alertMes

    def dropOut(self):
        pass

    def getCourseList(self):
        courseList = self.driver.find_elements_by_css_selector('#courseCard_Containor > h2')
        return [course.text for course in courseList]