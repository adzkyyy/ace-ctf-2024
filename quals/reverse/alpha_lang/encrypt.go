package main

import (
        "fmt"
        "math/big"
        "math/rand"
        "strings"
)

const FLAG = "ACECTF{k4m1_S4y4n9_R0bl0x_Roblox_Say4ng_k@m1_k@m1_Cint4_r0blox_120bl0x_c1nt4_K4M1_s4me_Sam3lah_c1Nt@k@n_r0bl0x_#robloxberjaya_gedagedigedageda0_@#oj#JP_go_!@#!!!#_go_tamago}"

var Constellations = []string{
        "Rizz",
        "Sigma",
        "Skibidi",
        "Mewing",
        "Gyatt",
        "FanumTax",
        "KaiCenat",
        "Ohio",
        "Roblox",
}

func main() {
	rand.Seed(rand.Int63n(0xdeadbeef))
	for i := 0; i < len(FLAG); i++ {
		x := big.NewInt(0)
		for j := 0; j < i; j++ {
			x.Mul(x, big.NewInt(2))
			x.Add(x, big.NewInt(rand.Int63n(2)))
		}
		for {
			t := new(big.Int)
			t.Mul(x, big.NewInt(13))
			t.Add(t, big.NewInt(37))
			t.Mod(t, big.NewInt(256))
			if t.Int64() == int64(FLAG[i]) {
				break
			}
			x.Add(x, big.NewInt(1))
		}
		v := []string{}
		for x.Sign() > 0 {
			t := new(big.Int)
			t.Mod(x, big.NewInt(9))
			v = append(v, Constellations[t.Int64()])
			x.Div(x, big.NewInt(9))
		}
		for i2, j := 0, len(v)-1; i2 < j; i2, j = i2+1, j-1 {
			v[i2], v[j] = v[j], v[i2]
		}
		fmt.Println(strings.Join(v, "."))
	}
}