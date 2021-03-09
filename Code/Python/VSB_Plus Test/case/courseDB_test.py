from common.funCourseDB import CourseDB_test
import ddt,unittest,os
from util import log
from selenium import webdriver
from util.gettestdata import huoqu_test
path=os.getcwd()
case_path=path+'\\data\\case.xlsx'
casedata=huoqu_test(case_path,3)
@ddt.ddt
class Testlogin(unittest.TestCase):
    def setUp(self):
        self.logs=log.log_message()
        self.derve=webdriver.Chrome()
        self.derve.implicitly_wait(10)
        self.login_fun=CourseDB_test(self.derve)

    @ddt.data(*casedata)
    def test_login1(self,casedata):
        self.name=casedata['short_name']
        self.suc=casedata['suc']
        self.assert_value = casedata['assert']
        self.derve.get_screenshot_as_file(path+'\\resultpang\\%s.png'%casedata)
        self.logs.info_log('Input Data: short_name:%s,suc:%s,assert:%s' % (self.name, self.suc, self.assert_value))
        self.re_data = self.login_fun.login(self.suc,self.name)
        self.assertEqual(self.re_data, self.assert_value)

    def tearDown(self):
        self.derve.quit()
