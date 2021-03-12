from common.funCourseDB import login
import ddt,unittest,os,time
from util import log
from selenium import webdriver
from util.gettestdata import huoqu_test
path=os.getcwd()
case_path=path+'\\data\\case.xlsx'
casedata=huoqu_test(case_path,0)
faultyTest_data = huoqu_test(case_path,1)
@ddt.ddt
class TestLogin(unittest.TestCase):
    def setUp(self):
        self.logs=log.log_message()
        self.driver=webdriver.Chrome()
        self.driver.implicitly_wait(10)
        self.login=Login_test(self.driver)

    def test_login(self):
        # Set the datas
        self.SID = '200362586'
        self.pw = '200362586'
        self.suc = '1'
        self.assert_value = 'Welcome Yang, Jingkang'

        # Print the input data with logs
        self.logs.info_log('Input Data: SID: %s, password: %s,suc: %s, assert: %s' % (self.SID, self.pw self.suc, self.assert_value))
        loginMsg = self.login.login(self.SID, self.pw, self.suc)
        self.assert(loginMsg, self.assert_value)
        # self.assertTrue(loginSuc) if self.suc == '1' else self.assertFalse(loginSuc)

    def tearDown(self):
        self.driver.quit()
