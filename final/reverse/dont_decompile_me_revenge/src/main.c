#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>


#define anti_ida_decompiler                     \
  __asm__ ("  push     r8       \n"             \
           "  push     rsi      \n"             \
           "  push     rcx      \n"             \
           "  push     rax      \n"             \
           "  xor      eax, eax \n"             \
           "  jz       opaque   \n"             \
           "  add      rsp, 777 \n"             \
 "opaque:             \n"             \
           "  pop      rax      \n"             \
           "  pop      rcx      \n"             \
           "  pop      rsi      \n"             \
           "  pop      r8       \n" \
	   "lea rax, [rip+ACE%=]\n" \
	   "push rax\n" \
	   "ret\n" \
	   "ACE%=:\n" : : : "rax" );


char answer[] = {107, 110, 109, 125, 127, 81, 113, 101, 96, 122, 113, 109, 82, 93, 110, 123, 84, 87, 103, 119, 101, 108, 120, 119, 73, 88, 109, 111, 105, 67, 76, 119, 79, 68, 73, 87, 84, 73, 70, 89, 64, 78, 62};

int check(unsigned char *flag, unsigned char *ans) {
  int i, l = strlen(flag);
  for(i = 0; i < l; i++) {
    anti_ida_decompiler;
    if ((flag[i] ^ flag[i+1] ^ i ^ 0x69) != ans[i]) {
      return 1;
    }
  }
  return 0;
}

int main(int argc, char **argv) {
  if (argc < 2) {
    return 1;
  }
  if (check(argv[1], answer) == 0) {
    puts("👍");
  } else {
    puts("👎");
  }
  return 0;
}
