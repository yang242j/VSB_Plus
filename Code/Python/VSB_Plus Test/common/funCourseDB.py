import yaml,os
path=os.getcwd()
from util import log
class CourseDB_test:#封装
    def __init__(self,driver):#
        self.driber=driver
        self.logs = log.log_message()
        self.file=open(path+"\\data\\page_data.yaml", "r",encoding= "utf-8")
        self.data=yaml.load(self.file)
        self.file.close()
        self.lo_url=self.data['courseDB'].get('url')
        self.input_box=self.data['courseDB'].get('input_box')
        self.title=self.data['courseDB'].get('selectedTitle')
        self.selectButton=self.data['courseDB'].get('clickButton')
        self.message=self.data['courseDB'].get('message')
        self.driber.get(self.lo_url)

    def login(self,suc,short_name):
        try:
            self.driber.find_element_by_id(self.input_box).clear()
            self.driber.find_element_by_id(self.input_box).send_keys(short_name)
            self.driber.find_element_by_xpath(self.selectButton).click()
            if suc=='1':
                 self.login_su = self.driber.find_element_by_id(self.title).text
                 return self.login_su
            if suc=='0':
                self.login_err=self.driber.find_element_by_id(self.message).text
                return self.login_err
        except Exception as e:
            self.logs.error_log('Fail to run the test，reason：%s'%e)
        finally:
            self.driber.quit()
