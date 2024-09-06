// gcc -w -o sort sort.c
#include <stdio.h>
#include <stdint.h>
#include <stdlib.h>

// just quick sort algorithm, no vuln
void quick_sort(uint64_t *s, int l, int r){
        if (l >= r) return;
        int i = l, j = r;
        uint64_t x = s[(l + r) / 2];
        while (i <= j){
                while (s[i] < x) i++;
                while (s[j] > x) j--;
                if (i <= j){
                        uint64_t t = s[i];
                        s[i] = s[j];
                        s[j] = t;
                        i++; j--;
                }
        }
        quick_sort(s, l, j);
        quick_sort(s, i, r);
}

void ezwin(){
        system("/bin/sh");
}

int main(int argc, char **argv){
        int n;
        uint64_t s[0x100];

        printf("len array: ");
        scanf("%d", &n);

	printf("input array (e.g., 3 2 1 ...)\n");
        for (int i = 0; i < n; i++){
                scanf("%ld", &s[i]);
        }
        
	quick_sort(s, 0, n - 1);
        printf("sorted array: ");
        for (int i = 0; i < n; i++){
                printf("%ld ", s[i]);
        } putchar('\n');
        
}
