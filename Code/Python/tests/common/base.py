from selenium.webdriver.common.by import By

class LoginPage():
    def __init__(self, driver):
        self.driver = driver

    def login(self, sid, password):
        sidInput = self.driver.find_element_by_name("studentid")
        sidInput.send_keys(sid)

        pdInput = self.driver.find_element_by_name("password")
        pdInput.send_keys(password)

        loginbnt = self.driver.find_element_by_xpath("/html/body/section/div/form/div[3]/input[1]")
        loginbnt.click()