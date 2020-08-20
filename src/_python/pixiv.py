from pixivpy3 import *
import urllib.request
import os.path

id = os.environ['PIXIV_ID']
password = os.environ['PIXIV_PASSWORD']

aapi = AppPixivAPI()
aapi.login(id, password)

def main():
    """
    json_result = aapi.user_illusts('6203904')
    for illust in json_result.illusts:
      aapi.download(illust.image_urls.large, path='../public/_static/temp')
      print(illust.image_urls.large)
    """
main()