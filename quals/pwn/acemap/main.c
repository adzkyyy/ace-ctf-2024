#define _GNU_SOURCE
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <fcntl.h>
#include <sys/mman.h>

struct mapper {
        void *address;
        size_t size;
} acemap;

static void err(const char *msg);
static void getbuf(const char *msg, char *buf, int len);
static ssize_t getnum(const char *msg);
static void handle_mmap(struct mapper *ace);
static void handle_munmap(struct mapper *ace);
static void handle_store(struct mapper *ace);
static void handle_load(struct mapper *ace);

int main(int argc, char *argv[]){
        for(;;){
                puts("1. mmap\n2. munmap\n3. store\n4. load");
                switch (getnum("> ")){
                        case 1: handle_mmap(&acemap); break;
                        case 2: handle_munmap(&acemap); break;
                        case 3: handle_store(&acemap); break;
                        case 4: handle_load(&acemap); break;
                        case 5: exit(0);
                        default: puts("invalid choice"); break;
                }
        }
}

static void handle_mmap(struct mapper *ace){

        size_t address = getnum("address: ");
        size_t size = getnum("size: ");

        ace->size = size;

        if (ace->address){
                puts("yo that's not empty");
                return;
        }

        if ((ace->address = mmap((void*)address, ace->size, PROT_READ | PROT_WRITE, MAP_PRIVATE | MAP_ANONYMOUS, -1, 0)) == MAP_FAILED)
        err("mmap failed");

        puts("mmapped");
        return;
}

static void handle_munmap(struct mapper *ace){

        if (!ace->address) {
                puts("no page to munmap");
                return;
        }

        munmap(ace->address, ace->size);
        ace->address = NULL;
        ace->size = 0;
        puts("munmapped");

        return;
}

static void handle_store(struct mapper *ace){
        size_t offset;

        if (!ace->address){
                puts("not yet mmap");
                return;
        }

        if ((offset = getnum("offset: ")) > ace->size){
                puts("out of range");
                return;
        }

        char *buff = ((char *)ace->address + offset);
        getbuf("data: ", buff, ace->size - offset);
}

static void handle_load(struct mapper *ace){
        size_t offset;

        if (!ace->address){
                puts("not yet mmap");
                return;
        }

        if ((offset = getnum("offset: ")) > ace->size){
                puts("out of range");
                return;
        }

        char *buff = ((char *)ace->address + offset);
        write(STDOUT_FILENO, &((char*)ace->address)[offset], ace->size - offset);
        putchar('\n');
}

static void getbuf(const char *msg,char *buf, int len){
        printf("%s", msg);
        ssize_t recv = 0;
        while (recv < len){
                if (read(STDIN_FILENO, &buf[recv], 1) < 0) exit(1);
                if (buf[recv] == '\n') {
                        buf[recv] = '\0';
                        break;
                } recv++;
        }
}

static ssize_t getnum(const char *msg){
        char buf[0x20] = {};
        getbuf(msg, buf, sizeof(buf));
        return atoll(buf);
}

static void err(const char *msg){
        puts(msg);
        _exit(1);
}

__attribute__((constructor))
void setup(void){
        alarm(60);
        setbuf(stdin, NULL);
        setbuf(stdout, NULL);
}
