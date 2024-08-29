from Crypto.Cipher import AES
from pwn import xor
import base64
import random
import string

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
    cipher = input('Enter the encrypted text: ')
    for i in range(0xffff):
        try:
            random.seed(i)
            characters = string.ascii_letters + string.digits
            key = (''.join(random.choice(characters) for _ in range(32))).encode()
            aes = AESCipher(key)
            pt = 'Welcome crypto challenge ACE CTF2024!'
            decrypted = aes.decrypt(cipher)
            if decrypted[0] == 'W':
                print(decrypted)
                xor_key = xor(key, pt.encode()[:len(key)])
                xor_key = base64.b64encode(xor_key).decode()
                print(xor_key)
                break
        except:
            pass
