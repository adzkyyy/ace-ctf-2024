#include <asm/unistd_64.h>
#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <unistd.h>
#include <string.h>
#include <seccomp.h>

#define MAX 0x10

struct acenote {
  char title[0x20];
  char content[0x50];
};

struct acenote *notes[MAX];

void create(struct acenote **note);
void delete(struct acenote **note);
void view(struct acenote **note);

void getbuf(const char *msg, char *buf, int len);
int getint(const char *msg);

int main(){
    while (1){
        puts("1. create\n2. view\n3. delete\n4. exit");
        int choice = getint("> ");
        switch (choice){
            case 1:
                create(notes);
                break;
            case 2:
                view(notes);
                break;
            case 3:
                delete(notes);
                break;
            case 4:
                exit(0);
                break;
            default:
                printf("invalid choice\n");
                break;
        }
    }
}

void create(struct acenote **note){
    int index = getint("index: ");
    if (index < 0 || index >= MAX) return;
    struct acenote *newnote = malloc(sizeof(struct acenote));
    if (!newnote) exit(1);
    getbuf("title: ", newnote->title, sizeof(newnote->title));
    getbuf("content: ", newnote->content, sizeof(newnote->content));
    note[index] = newnote;
}

void view(struct acenote **note){
    int index = getint("index: ");
    if (index < 0 || index >= MAX) return;
    struct acenote *viewnote = note[index];
    if (viewnote) {
        printf("title: %s\n", viewnote->title);
        printf("content: %s\n", viewnote->content);
    }
}

void delete(struct acenote **note){
    int index = getint("index: ");
    if (index < 0 || index >= MAX) return;
    // you know what to do
    free(note[index]);
}

int getint(const char *msg){
    char buf[0x10];
    getbuf(msg, buf, sizeof(buf));
    return atoi(buf);
}

void getbuf(const char *msg,char *buf, int len){
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

__attribute__((constructor))
void setup() {
  setvbuf(stdin, NULL, _IONBF, 0);
  setvbuf(stdout, NULL, _IONBF, 0);
}
