import time

FLAG = "ACECTF{im_pretty_sure_flag_is_not_that_long_btw_its_fake_flag_lol}" if "FLAG" not in os.environ else os.environ['FLAG']
N = 0x11b4c225f4dc385553faef71fd12d7a7d3731eebb47d01df2bd9c06cc95d67d933a3867dc3ef17547ae5a969dbc985489a3e835ddb0f8e1eb82b2cb84a5b168f74a808a0b7accbc1513cd416a5e8a4055a2823e192bdbe5da3583b11b0a1697a5a47
e = 0x10001

def able(s):
    a = inverse_mod(e, N)
    b = pow(a, 2, N)
    return (pow(e, s, N) + pow(a, s, N) + pow(b, s, N)) % N

def unsolv(nbit):
    pbit = nbit // 3
    p = random_prime(1<<pbit)
    while True:
        q = random_prime(1<<pbit)
        r = (q << (pbit//2) | q >> (pbit//2)) & ((1<<pbit)-1)
        if is_prime(r):
            break
    return p * q * r, prod(map(lambda x: next_prime(x//(1<<472)), [p, q, r])), able((q * r) % (1 << pbit))

def point(E, n):
    while True:
        x = randrange(1, n-1)
        if E.is_x_coord(x):
            break
    return E.lift_x(Integer(x))

if __name__ == '__main__':
    
    print("[*] Waiting for params...", end="\r", flush=True)
    start = time.time()
    
    n, g, u = unsolv(1536)
    a, b = [randrange(1, g-1) for _ in '01']
    
    E = EllipticCurve(Zmod(g), [a, b])
    G = point(E, g)
    
    secret = randrange(1, 1<<64)
    P = secret * G
    
    print("[+] It took {:.2f} seconds".format(time.time() - start))
    print(f"n = {n}")
    print(f"u = {u}")
    print(f"G = {G.xy()}")
    print(f"P = {P.xy()}")
    
    try:
        if int(input("What value of secret? ")) == secret:
            print(FLAG)
        else:
            print("Wrong")
            exit()
    except Exception as e:
        print("Nope")
        exit()
