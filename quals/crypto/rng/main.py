from Crypto.Cipher import AES
from pwn import xor
import base64
import random
import string
import os

FLAG = os.getenv('FLAG')

class AESCipher:
    def __init__(self, key):
        self.bs = 32
        self.key = key

    def encrypt(self, raw):
        raw = self._pad(raw).encode('utf-8')
        iv = random.randbytes(AES.block_size)
        cipher = AES.new(self.key, AES.MODE_CBC, iv)
        return base64.b64encode(iv + cipher.encrypt(raw)).decode('utf-8')
    
    def decrypt(self, enc):
        enc = base64.b64decode(enc)
        iv = enc[:AES.block_size]
        cipher = AES.new(self.key, AES.MODE_CBC, iv)
        return self._unpad(cipher.decrypt(enc[AES.block_size:])).decode('utf-8')

    def _pad(self, s):
        return s + (self.bs - len(s) % self.bs) * chr(self.bs - len(s) % self.bs)

    @staticmethod
    def _unpad(s):
        return s[:-ord(s[len(s)-1:])]

if __name__ == '__main__':
    seed = [random.randint(0, 0xffff) for i in range(32)]
    seed = random.choice(seed); random.seed(seed)
    characters = string.ascii_letters + string.digits
    key = (''.join(random.choice(characters) for _ in range(32))).encode()
    aes = AESCipher(key)

    pt = 'Welcome crypto challenge ACE CTF2024!'
    print('You have 3 chances to break this. Good luck!')
    attempt = 3
    encrypted = aes.encrypt(pt)
    print('Encrypted: ' + encrypted)
    while attempt > 0:
        try:
            print('Attempt left: ' + str(attempt))
            key = input('Enter the key: ').encode()
            key = base64.b64decode(key)
            key = xor(key, pt.encode()[:len(key)])
            attemptaes = AESCipher(key)
            decrypted = attemptaes.decrypt(encrypted)
            if decrypted == pt:
                print(FLAG)
                break
            else:
                print('Wrong key. Try again!')
                attempt -= 1
        except KeyboardInterrupt:
            exit()
        except:
            print('Wrong key. Try again!')
            attempt -= 1
