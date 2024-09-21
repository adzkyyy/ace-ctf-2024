from command import CAAS
import os

nonce = 0
nonce_list = []

def encrypt(caas):
    global nonce
    plain = bytes.fromhex(input("plaintext: ").strip())
    if b'cat flag' in plain:
        print("Invalid Command 'cat flag'")
        exit()
    
    cipher, tag = caas.encrypt(nonce.to_bytes(16, byteorder='big'), plain)
    print("ciphertext:", cipher.hex())
    print("tag:", tag.hex())
    nonce += 1

def decrypt(caas):
    nonce = bytes.fromhex(input("nonce: ").strip())
    cipher = bytes.fromhex(input("ciphertext: ").strip())
    tag = bytes.fromhex(input("tag: ").strip())

    if nonce in nonce_list:
        print('Nonce already on list')
        exit()

    nonce_list.append(nonce)
    plain = caas.decrypt(nonce, cipher, tag)

    if plain is None:
        print('No Flag :(')
        exit()

    print("plaintext:", plain.hex())

def execute(caas):
    nonce = bytes.fromhex(input("nonce: ").strip())
    cipher = bytes.fromhex(input("ciphertext: ").strip())
    tag = bytes.fromhex(input("tage: ").strip())
    plain = caas.decrypt(nonce, cipher, tag)

    if plain is not None:
        cmds = P.split(b';')
        for cmd in cmds:
            if cmd.strip() == b'cat flag':
                with open('./flag') as f:
                    print(f.read())
            else: print('Unknown Command')
    else: print('No Flag :(')
    exit()


def main():
    caas = CAAS(os.urandom(16))

    while True:
        print("1. encrypt")
        print("2. decrypt")
        print("3. execute")
        print("4. exit")
        option = int(input('> '))
        match(option):
            case 1:
                encrypt(caas)
            case 2:
                decrypt(caas)
            case 3:
                execute(caas)
            case _:
                return


if __name__ == '__main__':
    main()
