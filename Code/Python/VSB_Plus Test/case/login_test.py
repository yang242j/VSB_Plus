from common.funCourseDB import Login_test
import ddt,unittest,os,time
from util import log
from selenium import webdriver
from util.gettestdata import huoqu_test
path=os.getcwd()
case_path=path+'\\data\\case.xlsx'
casedata=huoqu_test(case_path,2)

@ddt.ddt
class TestLogin(unittest.TestCase):
    def setUp(self):
        self.logs=log.log_message()
        self.driver=webdriver.Chrome()
        self.driver.maximize_window()
        self.driver.implicitly_wait(10)
        self.login=Login_test(self.driver)

    @ddt.data(*casedata)
    def test_login(self, casedata):
        # Set the datas
        self.sid = casedata['sid']
        self.pwd = casedata['pwd']
        self.suc = casedata['suc']
        self.assert_value = casedata['assert']
    
        # Print the input data with logs
        self.logs.info_log('Input Data: SID: %s, password: %s,suc: %s, assert: %s' % (self.sid, self.pwd, self.suc, self.assert_value))
        loginMsg = self.login.login(self.sid, self.pwd, self.suc)
        # Get screenshot for every test
        self.driver.get_screenshot_as_file(path+'/resultpang/login_test/%s_%s.png' % (casedata['module'],casedata['id']))
        # Compare the test result with expection
        self.assertEqual(loginMsg, self.assert_value)
        if self.suc == '1': 
            self.assertTrue(self.login.pieShow())
            self.assertTrue(self.login.lineShow())
        
    def tearDown(self):
        self.driver.quit()
