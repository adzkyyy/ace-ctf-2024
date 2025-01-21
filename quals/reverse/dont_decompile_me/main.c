#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define TRICK \
	asm(".intel_syntax noprefix;\n" \
	"lea rax, [rip+ACE%=]\n" \
	"push rax\n" \
	"ret\n" \
	"ACE%=:\n" \
	".att_syntax" \
	: : : "rax");

int main(int argc, char *argv[]){
	TRICK;
	if (argc < 2) exit(1);
	TRICK;
	const char enc[] = "\x0c\xc3\xda\xe7\x9f\x60\x52\x9b\xfa\xc8\x81\x2d\x4d\x41\x75\xbd\x3e\xf4\xc0\xc0\xae\x45\x46\x9f\xec\xfe\x94\x27\x5c\x41\x76\xbc\x12\xf7\xf6\xd0\xa3\x49\x5c\x86\xc3\xe3\x8a\x2b\x5d\x7a\x40\xbc\x22\xdf\xfb\xc1\xa9\x53\x4e\xad\xf5\xe3\xa7\x78\x50\x7f\x6b\xbb\x12\xef\xf9\xc2\xf1\x5b";
	TRICK;
	const char key[] = "\x4d\x80\x9f\xa4\xcb\x26\x29\xf2\x9c\x97\xf8\x42\x38\x1e\x1f\xc8";

	TRICK;
	size_t len = strlen(argv[1]);
	
	TRICK;
	for (int i=0; i < len; i++){
		TRICK;
		argv[1][i] ^= key[i % (sizeof(key)-1)];
	}
	TRICK;
	if (memcmp(argv[1], enc, sizeof(enc)) == 0) {
		TRICK;
		puts("👍");
	} else {
		TRICK;
		puts("👎");
	}
}
