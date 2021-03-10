import yaml,os
path=os.getcwd()
from util import log
class CourseDB_test:#封装
    def __init__(self,driver):#
        self.driver=driver
        self.logs = log.log_message()
        self.file=open(path+"\\data\\page_data.yaml", "r",encoding= "utf-8")
        self.data=yaml.load(self.file)
        self.file.close()
        self.lo_url=self.data['courseDB'].get('url')
        self.input_box=self.data['courseDB'].get('input_box')
        self.title=self.data['courseDB'].get('selectedTitle')
        self.selectButton=self.data['courseDB'].get('clickButton')
        self.message=self.data['courseDB'].get('message')
        self.fullName=self.data['courseDB'].get('fullName')
        self.faultyBtn = self.data['courseDB'].get('faultyBtn')
        self.faultySelected = self.data['courseDB'].get('faultySelected')
        self.courseList = self.data['courseDB'].get('courseList')
        self.chart = self.data['courseDB'].get('chart')
        self.driver.get(self.lo_url)

    def search(self,suc,short_name):
        try:
            self.driver.find_element_by_id(self.input_box).clear()
            self.driver.find_element_by_id(self.input_box).send_keys(short_name)
            self.driver.find_element_by_xpath(self.selectButton).click()
            if suc=='1':
                 self.search_res = self.driver.find_element_by_id(self.fullName).text
                 charts = self.driver.find_elements_by_id(self.chart)
                 self.chartExist = True if len(charts) == 1 else False
                 return self.search_res, self.chartExist
            if suc=='0':
                self.search_err=self.driver.find_element_by_id(self.message).text
                return self.search_err, False
        except Exception as e:
            self.logs.error_log('Fail to run the test，reason：%s'%e)
        finally:
            self.driver.quit()

    # def chartExist(self):
    #     if self.driver.find_element_by_id(self.chart) != None:
    #         return True
    #     else:
    #         return False

    def setFacFilter(self, faultyName):
        try:
            faultys = self.driver.find_elements_by_class_name(self.faultyBtn)
            setFac = None
            for faulty in faultys:
                if faulty.text == faultyName: 
                    setFac = faulty
                    break
            faulty.click()
            courseList = self.driver.find_elements_by_class_name(self.courseList)
            result = [cour.text for cour in courseList]
            return result
        except Exception as e:
            self.logs.error_log('Fail to run the test，reason：%s'%e)
        finally:
            self.driver.quit()

    def clearFacFilter(self):
        try:
            selecteds = self.driver.find_elements_by_class_name(self.faultySelected)
            for selected in selecteds:
                selected.click()
        except Exception as e:
            self.logs.error_log('Fail to run the test，reason：%s'%e)
        finally:
            self.driver.quit()