package main

import (
	"fmt"
	"math/big"
	"strings"
)

func main()  {
	a := []string {
		"KaiCenatLFanumTax",
		"KaiCenatLOhio",
		"OhioLRizz",
		"KaiCenatLOhio",
		"RobloxLKaiCenat",
		"OhioLSigma",
		"SigmaLGyattLRizz",
		"SigmaLSkibidiLSkibidi",
		"MewingLKaiCenatLFanumTax",
		"GyattLMewingLRoblox",
		"KaiCenatLOhioLKaiCenat",
		"SkibidiLSkibidiLRizzLFanumTax",
		"GyattLSigmaLRizz",
		"SigmaLSigmaLSkibidiLSkibidiLRizz",
		"SigmaLSkibidiLKaiCenatLKaiCenatLGyatt",
		"GyattLOhioLFanumTaxLGyattLSkibidi",
		"KaiCenatLRizzLFanumTaxLSigmaLGyatt",
		"SigmaLSkibidiLOhioLOhioLMewingLOhio",
		"SigmaLSkibidiLKaiCenatLSigmaLRizzLOhio",
		"MewingLMewingLMewingLFanumTaxLRobloxLKaiCenat",
		"SigmaLRobloxLMewingLGyattLRobloxLMewingLOhio",
		"RobloxLRobloxLFanumTaxLSkibidiLFanumTaxLRizz",
		"KaiCenatLSkibidiLRizzLRobloxLFanumTaxLSigmaLRoblox",
		"SigmaLFanumTaxLGyattLGyattLKaiCenatLMewingLMewing",
		"GyattLRobloxLOhioLSkibidiLRizzLRobloxLFanumTax",
		"FanumTaxLGyattLRizzLFanumTaxLGyattLSkibidiLSigmaLGyatt",
		"SigmaLGyattLGyattLSkibidiLSkibidiLRobloxLMewingLSkibidiLSkibidi",
		"SkibidiLSkibidiLKaiCenatLMewingLRobloxLRizzLOhioLSkibidiLMewing",
		"SigmaLOhioLOhioLFanumTaxLOhioLFanumTaxLRizzLOhioLFanumTax",
		"SigmaLRizzLSigmaLFanumTaxLGyattLSkibidiLOhioLKaiCenatLFanumTaxLOhio",
		"SigmaLGyattLOhioLFanumTaxLRobloxLSkibidiLFanumTaxLSigmaLRizzLRizz",
		"FanumTaxLSkibidiLRobloxLSigmaLOhioLSigmaLSkibidiLRobloxLRobloxLRoblox",
		"SigmaLRizzLSkibidiLGyattLFanumTaxLKaiCenatLKaiCenatLRizzLKaiCenatLSigmaLSkibidi",
		"SigmaLSkibidiLKaiCenatLRobloxLSigmaLSkibidiLRobloxLMewingLKaiCenatLMewingLFanumTax",
		"GyattLSigmaLRobloxLSkibidiLSigmaLSkibidiLKaiCenatLKaiCenatLRobloxLFanumTaxLRizz",
		"GyattLKaiCenatLRobloxLRobloxLSigmaLKaiCenatLOhioLFanumTaxLKaiCenatLKaiCenatLSkibidi",
		"OhioLGyattLSkibidiLKaiCenatLRobloxLKaiCenatLKaiCenatLMewingLKaiCenatLRizzLKaiCenat",
		"MewingLMewingLRobloxLRobloxLSigmaLFanumTaxLGyattLMewingLRizzLOhioLFanumTaxLSigma",
		"FanumTaxLRizzLSkibidiLGyattLKaiCenatLKaiCenatLSkibidiLOhioLSkibidiLGyattLMewingLRoblox",
		"KaiCenatLOhioLOhioLMewingLSigmaLOhioLMewingLRobloxLSigmaLKaiCenatLRizz",
		"MewingLRizzLSkibidiLKaiCenatLSkibidiLFanumTaxLOhioLKaiCenatLRobloxLGyattLRizzLSkibidiLRizz",
		"GyattLGyattLSigmaLSkibidiLKaiCenatLSigmaLOhioLSigmaLMewingLGyattLFanumTaxLSkibidiLSkibidi",
		"GyattLGyattLRobloxLSigmaLOhioLOhioLKaiCenatLGyattLRizzLRizzLRizzLRobloxLKaiCenat",
		"SigmaLRobloxLSigmaLKaiCenatLMewingLSkibidiLKaiCenatLSigmaLOhioLGyattLMewingLSkibidiLOhioLRoblox",
		"SkibidiLKaiCenatLFanumTaxLSigmaLRobloxLSigmaLMewingLFanumTaxLMewingLRizzLGyattLRizzLGyattLOhio",
		"MewingLMewingLKaiCenatLSigmaLOhioLSigmaLRobloxLRobloxLRizzLMewingLFanumTaxLRizzLFanumTaxLMewing",
		"SkibidiLRizzLKaiCenatLRobloxLMewingLGyattLFanumTaxLSkibidiLSkibidiLGyattLSigmaLMewingLMewingLSkibidiLFanumTax",
		"KaiCenatLRizzLRizzLRizzLRizzLGyattLKaiCenatLSkibidiLSigmaLRobloxLOhioLKaiCenatLSkibidiLRobloxLFanumTax",
		"GyattLSkibidiLSigmaLSigmaLMewingLFanumTaxLKaiCenatLFanumTaxLMewingLRizzLGyattLGyattLFanumTaxLRobloxLRizz",
		"SigmaLSigmaLKaiCenatLGyattLRobloxLFanumTaxLMewingLFanumTaxLGyattLSkibidiLSigmaLMewingLMewingLSkibidiLKaiCenatLMewing",
		"SkibidiLSkibidiLRobloxLSkibidiLSigmaLRizzLKaiCenatLSigmaLKaiCenatLRizzLKaiCenatLOhioLSkibidiLOhioLFanumTaxLKaiCenat",
		"SigmaLGyattLFanumTaxLRizzLGyattLSkibidiLOhioLKaiCenatLOhioLSkibidiLOhioLKaiCenatLKaiCenatLRobloxLSkibidiLRoblox",
		"SigmaLRizzLSkibidiLKaiCenatLOhioLFanumTaxLGyattLRobloxLSkibidiLSkibidiLRizzLMewingLKaiCenatLSigmaLRobloxLRobloxLSigma",
		"MewingLKaiCenatLKaiCenatLGyattLMewingLRizzLGyattLRizzLOhioLSigmaLSigmaLOhioLKaiCenatLOhioLOhioLGyattLGyatt",
		"SkibidiLRobloxLKaiCenatLFanumTaxLMewingLSigmaLMewingLMewingLOhioLSkibidiLKaiCenatLFanumTaxLFanumTaxLSigmaLRobloxLFanumTaxLRoblox",
		"RobloxLRizzLSigmaLSkibidiLSkibidiLRizzLMewingLGyattLRobloxLRobloxLSkibidiLKaiCenatLRizzLRizzLMewingLSkibidiLRoblox",
		"GyattLRizzLMewingLFanumTaxLGyattLKaiCenatLRizzLKaiCenatLFanumTaxLFanumTaxLGyattLRizzLOhioLSigmaLFanumTaxLKaiCenatLOhio",
		"GyattLRobloxLMewingLMewingLOhioLFanumTaxLRizzLSigmaLRobloxLFanumTaxLSigmaLRizzLGyattLRobloxLMewingLFanumTaxLSkibidiLOhio",
		"RobloxLKaiCenatLSigmaLKaiCenatLOhioLRizzLMewingLFanumTaxLRizzLSkibidiLGyattLSigmaLKaiCenatLGyattLGyattLGyattLKaiCenatLSigma",
		"MewingLKaiCenatLMewingLRobloxLSigmaLSigmaLGyattLKaiCenatLRizzLRizzLRizzLSkibidiLGyattLSigmaLMewingLFanumTaxLSkibidiLMewingLSkibidi",
		"KaiCenatLKaiCenatLRizzLSigmaLOhioLRobloxLRizzLSkibidiLFanumTaxLSkibidiLRobloxLRizzLGyattLMewingLSigmaLGyattLSkibidiLKaiCenat",
		"MewingLRobloxLFanumTaxLFanumTaxLSigmaLKaiCenatLRizzLFanumTaxLOhioLMewingLOhioLKaiCenatLKaiCenatLGyattLFanumTaxLOhioLRobloxLMewingLSigma",
		"MewingLSkibidiLFanumTaxLSkibidiLGyattLSkibidiLGyattLKaiCenatLOhioLMewingLSkibidiLOhioLOhioLFanumTaxLGyattLRizzLMewingLFanumTaxLSkibidi",
		"GyattLSigmaLOhioLRobloxLGyattLRobloxLFanumTaxLRobloxLRizzLOhioLGyattLKaiCenatLSigmaLSkibidiLKaiCenatLSkibidiLSkibidiLOhioLSigmaLRoblox",
		"OhioLRizzLMewingLRobloxLSkibidiLKaiCenatLMewingLRizzLFanumTaxLKaiCenatLKaiCenatLKaiCenatLMewingLKaiCenatLRizzLSigmaLRizzLMewingLRizzLMewing",
		"SkibidiLSigmaLGyattLKaiCenatLOhioLRizzLGyattLSkibidiLOhioLOhioLRizzLSigmaLMewingLSkibidiLSigmaLMewingLFanumTaxLRizzLKaiCenatLFanumTaxLRizz",
		"MewingLKaiCenatLSigmaLKaiCenatLMewingLGyattLRobloxLOhioLRizzLRobloxLKaiCenatLOhioLFanumTaxLOhioLRizzLFanumTaxLFanumTaxLKaiCenatLOhioLSigmaLFanumTax",
		"KaiCenatLRobloxLKaiCenatLSkibidiLKaiCenatLRizzLRobloxLMewingLGyattLKaiCenatLRobloxLKaiCenatLRizzLRobloxLFanumTaxLSkibidiLSigmaLSigmaLMewingLRizzLMewing",
		"SkibidiLSigmaLGyattLKaiCenatLRobloxLSkibidiLSigmaLKaiCenatLSkibidiLSigmaLOhioLMewingLKaiCenatLOhioLSigmaLOhioLGyattLSigmaLOhioLRobloxLKaiCenat",
		"GyattLRobloxLSigmaLFanumTaxLSigmaLRobloxLMewingLMewingLFanumTaxLMewingLOhioLFanumTaxLGyattLFanumTaxLRobloxLSkibidiLOhioLSigmaLOhioLRizzLSkibidiLSigma",
		"SigmaLRizzLRobloxLOhioLMewingLGyattLKaiCenatLSigmaLKaiCenatLGyattLGyattLMewingLSigmaLRobloxLMewingLRizzLMewingLMewingLKaiCenatLSkibidiLFanumTaxLSigmaLSkibidi",
		"SigmaLRizzLSigmaLMewingLRizzLOhioLSigmaLKaiCenatLRobloxLKaiCenatLSigmaLSigmaLFanumTaxLKaiCenatLSigmaLSkibidiLRizzLFanumTaxLRizzLMewingLRobloxLSkibidiLSkibidi",
		"KaiCenatLMewingLGyattLMewingLFanumTaxLSigmaLRizzLFanumTaxLGyattLSigmaLOhioLSkibidiLFanumTaxLMewingLRobloxLMewingLRizzLFanumTaxLSigmaLFanumTaxLGyattLRizz",
		"MewingLRizzLFanumTaxLKaiCenatLRobloxLRizzLRobloxLRobloxLRizzLOhioLOhioLRizzLRizzLRizzLOhioLSigmaLGyattLKaiCenatLRizzLGyattLMewingLGyattLOhio",
		"SigmaLSkibidiLRizzLSkibidiLKaiCenatLOhioLOhioLRobloxLKaiCenatLFanumTaxLRobloxLSkibidiLOhioLOhioLKaiCenatLGyattLFanumTaxLFanumTaxLSkibidiLMewingLFanumTaxLOhioLRobloxLFanumTax",
		"SigmaLGyattLRobloxLSkibidiLSkibidiLRobloxLKaiCenatLRobloxLGyattLSigmaLGyattLKaiCenatLKaiCenatLSkibidiLSkibidiLFanumTaxLKaiCenatLOhioLMewingLRizzLKaiCenatLSigmaLSkibidiLRizz",
		"KaiCenatLRobloxLGyattLRobloxLOhioLSkibidiLGyattLOhioLSkibidiLMewingLSigmaLFanumTaxLGyattLSigmaLKaiCenatLMewingLRobloxLFanumTaxLOhioLKaiCenatLRizzLKaiCenatLSigmaLSigma",
		"GyattLKaiCenatLRizzLRizzLRobloxLOhioLKaiCenatLRizzLRobloxLMewingLSkibidiLRobloxLRizzLGyattLKaiCenatLSigmaLRobloxLFanumTaxLRobloxLSigmaLSigmaLSigmaLRizzLKaiCenat",
		"SkibidiLSigmaLMewingLOhioLKaiCenatLSigmaLGyattLRizzLSkibidiLGyattLRizzLMewingLOhioLKaiCenatLGyattLRobloxLSigmaLSigmaLSkibidiLRobloxLGyattLGyattLKaiCenatLOhioLMewing",
		"MewingLOhioLMewingLMewingLRobloxLRizzLRobloxLFanumTaxLSkibidiLFanumTaxLRobloxLMewingLRobloxLGyattLOhioLOhioLFanumTaxLGyattLSigmaLRobloxLKaiCenatLRizzLRobloxLKaiCenatLRizz",
		"SigmaLSkibidiLSigmaLSkibidiLKaiCenatLMewingLKaiCenatLMewingLKaiCenatLKaiCenatLFanumTaxLMewingLMewingLOhioLOhioLSigmaLRobloxLFanumTaxLOhioLMewingLKaiCenatLRobloxLKaiCenatLRobloxLRobloxLSkibidi",
		"OhioLMewingLRizzLMewingLRizzLRobloxLMewingLKaiCenatLSigmaLOhioLSigmaLMewingLFanumTaxLRizzLOhioLRizzLSkibidiLRobloxLFanumTaxLRobloxLKaiCenatLRizzLGyattLSkibidiLRizz",
		"SigmaLSkibidiLGyattLSigmaLRizzLGyattLSigmaLSigmaLGyattLOhioLFanumTaxLFanumTaxLMewingLRizzLMewingLSigmaLOhioLRobloxLSkibidiLGyattLSigmaLSkibidiLRobloxLFanumTaxLOhioLOhio",
		"SigmaLRizzLMewingLSkibidiLRobloxLMewingLSigmaLSigmaLSigmaLSkibidiLKaiCenatLSigmaLFanumTaxLFanumTaxLRizzLMewingLKaiCenatLRobloxLMewingLMewingLSkibidiLMewingLKaiCenatLKaiCenatLGyattLMewingLRoblox",
		"SigmaLFanumTaxLOhioLOhioLOhioLGyattLKaiCenatLRizzLOhioLRobloxLMewingLFanumTaxLRobloxLKaiCenatLRobloxLMewingLFanumTaxLKaiCenatLRobloxLMewingLGyattLKaiCenatLRizzLRizzLRobloxLMewingLOhio",
		"SigmaLKaiCenatLGyattLRizzLKaiCenatLOhioLFanumTaxLKaiCenatLFanumTaxLFanumTaxLFanumTaxLOhioLSigmaLKaiCenatLMewingLOhioLOhioLSigmaLRobloxLOhioLRobloxLMewingLSigmaLGyattLSkibidiLRizzLGyatt",
		"MewingLSigmaLSigmaLFanumTaxLFanumTaxLRizzLMewingLFanumTaxLKaiCenatLFanumTaxLSigmaLRizzLSigmaLGyattLSkibidiLGyattLSigmaLSkibidiLSigmaLOhioLMewingLRizzLOhioLMewingLFanumTaxLRobloxLKaiCenat",
		"SkibidiLSigmaLMewingLOhioLOhioLFanumTaxLMewingLRizzLKaiCenatLSkibidiLOhioLGyattLMewingLRobloxLFanumTaxLMewingLRobloxLGyattLRizzLSigmaLMewingLKaiCenatLRizzLFanumTaxLMewingLOhioLOhioLOhio",
		"FanumTaxLSigmaLOhioLOhioLSkibidiLRobloxLKaiCenatLRobloxLKaiCenatLFanumTaxLFanumTaxLKaiCenatLSkibidiLRobloxLRobloxLMewingLRizzLMewingLKaiCenatLRobloxLGyattLGyattLSkibidiLRobloxLSigmaLKaiCenatLSkibidiLRoblox",
		"SkibidiLSkibidiLSkibidiLFanumTaxLMewingLSkibidiLSigmaLSigmaLRobloxLFanumTaxLSigmaLOhioLGyattLRizzLRobloxLMewingLRizzLFanumTaxLGyattLRizzLOhioLFanumTaxLGyattLRizzLMewingLSkibidiLMewingLRizz",
		"SkibidiLRizzLSkibidiLSkibidiLSkibidiLOhioLSigmaLKaiCenatLOhioLRizzLGyattLOhioLRizzLRobloxLRobloxLRizzLFanumTaxLMewingLFanumTaxLGyattLSkibidiLMewingLRizzLRizzLGyattLRobloxLSkibidiLOhioLSkibidi",
		"GyattLFanumTaxLKaiCenatLSigmaLKaiCenatLKaiCenatLRizzLFanumTaxLFanumTaxLKaiCenatLGyattLKaiCenatLRizzLRobloxLSkibidiLGyattLFanumTaxLKaiCenatLMewingLSkibidiLRizzLFanumTaxLRizzLMewingLFanumTaxLSkibidiLMewingLGyattLGyatt",
		"KaiCenatLFanumTaxLSkibidiLMewingLRizzLKaiCenatLFanumTaxLGyattLSkibidiLRobloxLRobloxLRizzLMewingLKaiCenatLKaiCenatLMewingLOhioLMewingLSkibidiLSkibidiLKaiCenatLSkibidiLOhioLSkibidiLRizzLSkibidiLOhioLFanumTaxLMewing",
		"RobloxLRobloxLSkibidiLOhioLMewingLRizzLGyattLOhioLRobloxLRobloxLRizzLKaiCenatLOhioLSkibidiLRizzLGyattLSkibidiLKaiCenatLRizzLSigmaLKaiCenatLKaiCenatLFanumTaxLRobloxLOhioLMewingLMewingLRobloxLSigma",
		"SkibidiLKaiCenatLRobloxLFanumTaxLSigmaLGyattLSkibidiLRobloxLKaiCenatLGyattLSigmaLKaiCenatLOhioLOhioLRobloxLRizzLKaiCenatLOhioLKaiCenatLSkibidiLMewingLKaiCenatLRizzLFanumTaxLRobloxLOhioLRobloxLRizzLFanumTaxLOhio",
		"MewingLKaiCenatLRobloxLRobloxLSigmaLFanumTaxLMewingLRobloxLGyattLKaiCenatLGyattLMewingLRizzLMewingLSigmaLMewingLKaiCenatLOhioLRizzLSigmaLRobloxLOhioLKaiCenatLKaiCenatLRobloxLSkibidiLRizzLOhioLRizzLSigma",
		"SigmaLMewingLSkibidiLRobloxLSkibidiLFanumTaxLMewingLRizzLRobloxLRizzLFanumTaxLOhioLMewingLRobloxLGyattLGyattLOhioLRobloxLSigmaLRobloxLFanumTaxLGyattLFanumTaxLRizzLRobloxLFanumTaxLMewingLRobloxLMewingLGyattLOhio",
		"SkibidiLRizzLFanumTaxLRizzLKaiCenatLFanumTaxLRizzLOhioLOhioLRobloxLRobloxLRizzLKaiCenatLGyattLOhioLOhioLOhioLFanumTaxLKaiCenatLMewingLMewingLSkibidiLKaiCenatLSkibidiLSkibidiLSkibidiLGyattLOhioLMewingLSigmaLMewing",
		"OhioLRizzLOhioLRobloxLGyattLMewingLRizzLMewingLKaiCenatLGyattLRobloxLGyattLKaiCenatLRizzLSigmaLRizzLKaiCenatLKaiCenatLKaiCenatLMewingLKaiCenatLFanumTaxLGyattLRizzLOhioLMewingLOhioLSkibidiLSkibidiLFanumTaxLMewing",
		"SkibidiLMewingLGyattLOhioLRizzLSigmaLGyattLSigmaLRizzLFanumTaxLRobloxLRizzLGyattLKaiCenatLRobloxLGyattLSigmaLSigmaLRobloxLRizzLFanumTaxLGyattLSigmaLFanumTaxLRizzLMewingLKaiCenatLSigmaLFanumTaxLRizzLSigma",
		"SkibidiLFanumTaxLSigmaLRizzLOhioLFanumTaxLGyattLSigmaLSigmaLGyattLGyattLFanumTaxLSigmaLSkibidiLSkibidiLMewingLOhioLFanumTaxLSigmaLKaiCenatLSigmaLOhioLGyattLRobloxLRizzLSigmaLSigmaLSigmaLOhioLOhioLOhioLOhio",
		"SkibidiLSigmaLRizzLRizzLOhioLSigmaLMewingLSigmaLMewingLRizzLRobloxLKaiCenatLSkibidiLKaiCenatLFanumTaxLRizzLRobloxLRobloxLKaiCenatLGyattLKaiCenatLSkibidiLMewingLRobloxLKaiCenatLFanumTaxLSigmaLFanumTaxLSigmaLGyattLMewingLOhio",
		"SigmaLMewingLKaiCenatLSkibidiLMewingLSigmaLKaiCenatLRizzLKaiCenatLOhioLOhioLOhioLKaiCenatLSkibidiLSigmaLFanumTaxLOhioLSkibidiLOhioLMewingLMewingLKaiCenatLRobloxLFanumTaxLSkibidiLKaiCenatLGyattLMewingLSkibidiLSkibidiLFanumTaxLRobloxLRizz",
		"SkibidiLFanumTaxLSigmaLSigmaLRizzLOhioLFanumTaxLRizzLRizzLGyattLRobloxLKaiCenatLGyattLKaiCenatLKaiCenatLSkibidiLOhioLRobloxLOhioLSkibidiLMewingLRizzLMewingLOhioLRobloxLFanumTaxLSkibidiLSkibidiLRobloxLSkibidiLGyattLOhioLFanumTax",
		"MewingLSigmaLOhioLSkibidiLMewingLGyattLFanumTaxLKaiCenatLFanumTaxLOhioLMewingLGyattLRizzLOhioLGyattLFanumTaxLRizzLSigmaLOhioLSkibidiLGyattLSkibidiLGyattLSigmaLKaiCenatLFanumTaxLRobloxLSkibidiLMewingLRizzLRizzLOhioLKaiCenat",
		"MewingLSkibidiLMewingLFanumTaxLMewingLSkibidiLOhioLSigmaLOhioLFanumTaxLRobloxLRizzLKaiCenatLMewingLOhioLSigmaLOhioLKaiCenatLOhioLGyattLGyattLOhioLSigmaLKaiCenatLRobloxLRizzLOhioLSigmaLFanumTaxLRobloxLSkibidiLSkibidiLRoblox",
		"OhioLSkibidiLOhioLSkibidiLRizzLMewingLSigmaLRizzLRobloxLFanumTaxLOhioLSigmaLKaiCenatLFanumTaxLFanumTaxLOhioLMewingLMewingLFanumTaxLFanumTaxLOhioLFanumTaxLFanumTaxLOhioLSigmaLRobloxLFanumTaxLRobloxLSigmaLFanumTaxLGyattLSkibidiLRizz",
		"GyattLRizzLOhioLRobloxLSigmaLMewingLOhioLOhioLOhioLRobloxLOhioLGyattLKaiCenatLFanumTaxLMewingLSkibidiLKaiCenatLMewingLGyattLSkibidiLGyattLMewingLKaiCenatLRobloxLFanumTaxLMewingLGyattLOhioLRobloxLSigmaLRizzLSkibidiLFanumTax",
		"GyattLKaiCenatLOhioLRizzLSkibidiLKaiCenatLRobloxLSigmaLSigmaLSigmaLKaiCenatLKaiCenatLSkibidiLMewingLFanumTaxLMewingLSigmaLMewingLOhioLOhioLGyattLOhioLKaiCenatLMewingLRobloxLRobloxLGyattLSkibidiLRizzLKaiCenatLOhioLOhioLSigmaLGyatt",
		"SigmaLOhioLFanumTaxLOhioLRobloxLGyattLGyattLOhioLRobloxLKaiCenatLRobloxLSkibidiLSigmaLFanumTaxLMewingLSkibidiLMewingLRobloxLFanumTaxLKaiCenatLMewingLRizzLKaiCenatLGyattLKaiCenatLSkibidiLGyattLMewingLRobloxLGyattLOhioLSkibidiLGyattLMewingLKaiCenat",
		"MewingLSkibidiLOhioLGyattLMewingLSkibidiLRizzLOhioLSkibidiLMewingLGyattLMewingLKaiCenatLMewingLKaiCenatLFanumTaxLOhioLRobloxLSkibidiLOhioLKaiCenatLSigmaLSigmaLRizzLFanumTaxLSigmaLOhioLRizzLKaiCenatLSkibidiLSkibidiLRizzLRizzLGyattLSkibidi",
		"FanumTaxLKaiCenatLRizzLOhioLRobloxLSkibidiLSigmaLRizzLSigmaLRobloxLMewingLMewingLSigmaLGyattLKaiCenatLOhioLMewingLFanumTaxLKaiCenatLOhioLOhioLSigmaLMewingLSigmaLMewingLKaiCenatLSigmaLRobloxLGyattLSigmaLRizzLOhioLMewingLFanumTax",
		"SigmaLRizzLRobloxLGyattLKaiCenatLRizzLGyattLFanumTaxLGyattLMewingLSigmaLOhioLMewingLMewingLRobloxLGyattLMewingLMewingLSkibidiLSigmaLGyattLRizzLKaiCenatLOhioLMewingLSigmaLGyattLSigmaLFanumTaxLGyattLRobloxLOhioLFanumTaxLSkibidiLFanumTaxLRoblox",
		"MewingLRobloxLOhioLMewingLFanumTaxLKaiCenatLRizzLGyattLFanumTaxLFanumTaxLSkibidiLMewingLRizzLOhioLFanumTaxLGyattLFanumTaxLRobloxLMewingLOhioLMewingLMewingLFanumTaxLGyattLKaiCenatLOhioLSkibidiLKaiCenatLRobloxLGyattLSigmaLSkibidiLMewingLMewingLKaiCenat",
		"SkibidiLMewingLKaiCenatLOhioLMewingLOhioLMewingLSigmaLOhioLRobloxLMewingLKaiCenatLSkibidiLSigmaLKaiCenatLSigmaLKaiCenatLRobloxLRizzLRizzLFanumTaxLMewingLFanumTaxLOhioLGyattLOhioLOhioLOhioLSkibidiLMewingLFanumTaxLSkibidiLKaiCenatLRizzLKaiCenatLOhio",
		"SigmaLRizzLFanumTaxLGyattLOhioLOhioLKaiCenatLOhioLOhioLOhioLKaiCenatLKaiCenatLGyattLSigmaLFanumTaxLRobloxLGyattLSigmaLRobloxLOhioLGyattLRobloxLFanumTaxLSigmaLMewingLOhioLFanumTaxLOhioLFanumTaxLMewingLOhioLSigmaLRobloxLRizzLMewingLGyattLSkibidi",
		"SigmaLFanumTaxLMewingLOhioLSigmaLKaiCenatLOhioLOhioLMewingLRobloxLKaiCenatLKaiCenatLSkibidiLMewingLRizzLRobloxLRobloxLOhioLSkibidiLRizzLKaiCenatLRizzLGyattLRizzLMewingLRizzLGyattLOhioLRobloxLOhioLRizzLFanumTaxLFanumTaxLSigmaLOhioLKaiCenat",
		"OhioLSigmaLSkibidiLSigmaLRobloxLRizzLKaiCenatLGyattLMewingLOhioLSigmaLFanumTaxLOhioLMewingLSigmaLRobloxLSigmaLRobloxLMewingLSigmaLRizzLOhioLMewingLGyattLRizzLSigmaLRobloxLFanumTaxLRizzLRobloxLFanumTaxLGyattLSkibidiLOhioLOhioLRoblox",
		"SigmaLRizzLSkibidiLSkibidiLOhioLSigmaLKaiCenatLRizzLFanumTaxLFanumTaxLMewingLOhioLFanumTaxLRobloxLSigmaLMewingLSigmaLFanumTaxLRobloxLSigmaLGyattLSigmaLOhioLSkibidiLKaiCenatLOhioLOhioLMewingLOhioLRizzLOhioLMewingLSigmaLRizzLSkibidiLGyattLSkibidiLKaiCenat",
		"SkibidiLRobloxLKaiCenatLFanumTaxLSigmaLMewingLFanumTaxLSkibidiLSigmaLOhioLGyattLFanumTaxLFanumTaxLKaiCenatLGyattLRizzLSigmaLOhioLMewingLSkibidiLRobloxLGyattLSkibidiLRizzLOhioLOhioLMewingLGyattLSkibidiLSkibidiLMewingLKaiCenatLMewingLSkibidiLFanumTaxLSigmaLFanumTaxLSkibidi",
		"FanumTaxLRizzLSkibidiLSkibidiLOhioLRizzLGyattLKaiCenatLSigmaLMewingLFanumTaxLRobloxLOhioLFanumTaxLMewingLRobloxLRobloxLRizzLFanumTaxLRobloxLSigmaLRobloxLRizzLMewingLGyattLKaiCenatLGyattLRobloxLSkibidiLFanumTaxLSkibidiLFanumTaxLGyattLMewingLSigmaLSigmaLRizzLGyatt",
		"SigmaLOhioLSigmaLFanumTaxLRizzLOhioLKaiCenatLOhioLMewingLFanumTaxLSigmaLOhioLRizzLRizzLFanumTaxLOhioLSkibidiLGyattLMewingLSigmaLFanumTaxLRizzLRizzLOhioLFanumTaxLSigmaLSkibidiLKaiCenatLSkibidiLSkibidiLSigmaLSigmaLFanumTaxLFanumTaxLOhioLMewingLRizzLRizz",
		"SigmaLFanumTaxLMewingLOhioLKaiCenatLRizzLFanumTaxLMewingLRobloxLMewingLKaiCenatLSigmaLGyattLRobloxLRobloxLOhioLKaiCenatLFanumTaxLRobloxLKaiCenatLKaiCenatLOhioLFanumTaxLSigmaLRobloxLGyattLRizzLRizzLRizzLRizzLRobloxLSkibidiLFanumTaxLGyattLMewingLSkibidiLKaiCenatLOhioLMewing",
		"FanumTaxLMewingLSigmaLSigmaLFanumTaxLOhioLRobloxLMewingLFanumTaxLOhioLGyattLKaiCenatLRizzLGyattLKaiCenatLRizzLSigmaLRizzLFanumTaxLRobloxLGyattLFanumTaxLKaiCenatLSkibidiLOhioLGyattLSkibidiLSkibidiLKaiCenatLFanumTaxLFanumTaxLRizzLFanumTaxLFanumTaxLSigmaLFanumTaxLOhioLOhioLKaiCenat",
		"SigmaLSkibidiLGyattLSigmaLSigmaLOhioLFanumTaxLFanumTaxLGyattLRobloxLSigmaLMewingLSkibidiLSigmaLGyattLRobloxLGyattLFanumTaxLRobloxLRobloxLOhioLSkibidiLSkibidiLOhioLRobloxLSkibidiLRizzLSkibidiLOhioLRizzLMewingLRobloxLMewingLGyattLSigmaLSigmaLSkibidiLGyattLSkibidiLRizz",
		"SkibidiLSkibidiLSkibidiLOhioLOhioLSkibidiLMewingLKaiCenatLMewingLOhioLRobloxLFanumTaxLOhioLSkibidiLOhioLSkibidiLRizzLRizzLKaiCenatLKaiCenatLSigmaLGyattLFanumTaxLFanumTaxLFanumTaxLFanumTaxLKaiCenatLRizzLKaiCenatLRobloxLRobloxLFanumTaxLSkibidiLSkibidiLRobloxLSigmaLFanumTaxLFanumTaxLRobloxLGyatt",
		"SkibidiLSigmaLSigmaLMewingLKaiCenatLFanumTaxLKaiCenatLOhioLSigmaLOhioLOhioLFanumTaxLSkibidiLKaiCenatLGyattLKaiCenatLKaiCenatLRizzLGyattLGyattLSkibidiLMewingLFanumTaxLMewingLGyattLSigmaLSigmaLGyattLRobloxLSkibidiLGyattLKaiCenatLSigmaLFanumTaxLGyattLFanumTaxLFanumTaxLOhioLMewingLFanumTax",
		"SigmaLSigmaLRobloxLFanumTaxLRobloxLMewingLKaiCenatLSigmaLKaiCenatLMewingLFanumTaxLSigmaLGyattLGyattLFanumTaxLOhioLMewingLRobloxLSkibidiLSkibidiLGyattLFanumTaxLKaiCenatLGyattLRizzLSkibidiLRobloxLMewingLRizzLFanumTaxLFanumTaxLSkibidiLKaiCenatLRobloxLOhioLOhioLOhioLFanumTaxLFanumTaxLMewing",
		"SigmaLRobloxLSkibidiLGyattLSkibidiLFanumTaxLOhioLOhioLSkibidiLOhioLRizzLGyattLRizzLFanumTaxLGyattLRizzLOhioLSkibidiLSkibidiLKaiCenatLKaiCenatLKaiCenatLOhioLFanumTaxLRizzLKaiCenatLRizzLMewingLFanumTaxLSkibidiLFanumTaxLFanumTaxLOhioLSkibidiLFanumTaxLOhioLMewingLRizzLMewingLKaiCenat",
		"SigmaLMewingLFanumTaxLSkibidiLSkibidiLSigmaLSkibidiLMewingLOhioLSigmaLGyattLFanumTaxLRizzLKaiCenatLRizzLMewingLMewingLRizzLSkibidiLKaiCenatLMewingLGyattLRobloxLFanumTaxLFanumTaxLKaiCenatLRizzLSkibidiLKaiCenatLMewingLRizzLSigmaLRobloxLMewingLFanumTaxLRizzLSigmaLSigmaLSigmaLKaiCenatLOhio",
		"RobloxLFanumTaxLRizzLRizzLSigmaLSigmaLOhioLFanumTaxLMewingLSkibidiLKaiCenatLSkibidiLRizzLRizzLRizzLRizzLSkibidiLSkibidiLOhioLMewingLSigmaLGyattLKaiCenatLRobloxLRobloxLRizzLFanumTaxLSkibidiLRobloxLKaiCenatLRizzLGyattLRizzLGyattLMewingLRizzLRobloxLKaiCenatLRobloxLSkibidi",
		"SigmaLRobloxLFanumTaxLMewingLKaiCenatLFanumTaxLRizzLOhioLRizzLOhioLRizzLRobloxLSkibidiLGyattLRizzLOhioLRobloxLFanumTaxLMewingLKaiCenatLKaiCenatLFanumTaxLOhioLMewingLKaiCenatLSkibidiLFanumTaxLGyattLGyattLKaiCenatLMewingLGyattLFanumTaxLSkibidiLRobloxLRizzLMewingLOhioLSkibidiLOhioLRizzLSigma",
		"SigmaLSkibidiLMewingLOhioLMewingLRizzLRizzLRizzLRizzLRobloxLRobloxLRizzLRobloxLFanumTaxLSigmaLSigmaLRobloxLRobloxLOhioLSigmaLSkibidiLSigmaLOhioLSkibidiLMewingLFanumTaxLFanumTaxLMewingLRizzLSkibidiLKaiCenatLGyattLMewingLSkibidiLRizzLFanumTaxLOhioLSkibidiLSigmaLMewingLFanumTaxLMewing",
		"SkibidiLOhioLKaiCenatLSkibidiLSkibidiLRizzLOhioLKaiCenatLSigmaLGyattLRizzLGyattLRizzLRobloxLRobloxLSkibidiLFanumTaxLGyattLMewingLGyattLGyattLMewingLSkibidiLOhioLRobloxLRobloxLOhioLKaiCenatLKaiCenatLKaiCenatLMewingLGyattLKaiCenatLSigmaLFanumTaxLOhioLFanumTaxLSkibidiLKaiCenatLKaiCenatLSkibidiLRizz",
		"SigmaLSigmaLOhioLSigmaLRobloxLGyattLSkibidiLFanumTaxLSigmaLGyattLMewingLSkibidiLRobloxLRizzLOhioLRobloxLMewingLKaiCenatLRizzLSigmaLSigmaLRizzLKaiCenatLSkibidiLSigmaLMewingLSigmaLRobloxLMewingLRobloxLSkibidiLSkibidiLSkibidiLGyattLGyattLGyattLSkibidiLKaiCenatLFanumTaxLMewingLRobloxLKaiCenat",
		"SigmaLGyattLOhioLFanumTaxLRizzLMewingLMewingLKaiCenatLGyattLGyattLSigmaLSigmaLMewingLOhioLKaiCenatLKaiCenatLSkibidiLSkibidiLFanumTaxLGyattLRobloxLSkibidiLRizzLOhioLRobloxLOhioLMewingLKaiCenatLSkibidiLKaiCenatLRizzLSigmaLRizzLSkibidiLRizzLSigmaLOhioLSkibidiLSkibidiLSigmaLSigmaLSigmaLSkibidi",
		"SkibidiLSigmaLOhioLRizzLKaiCenatLRobloxLRobloxLSkibidiLKaiCenatLFanumTaxLSkibidiLOhioLMewingLKaiCenatLSkibidiLSkibidiLMewingLOhioLSkibidiLMewingLOhioLGyattLSigmaLMewingLRizzLGyattLKaiCenatLFanumTaxLFanumTaxLRizzLFanumTaxLKaiCenatLFanumTaxLMewingLSigmaLGyattLOhioLKaiCenatLMewingLGyattLMewingLSigmaLSigma",
		"MewingLKaiCenatLKaiCenatLKaiCenatLRizzLRizzLGyattLSigmaLSkibidiLKaiCenatLGyattLFanumTaxLMewingLGyattLSigmaLKaiCenatLMewingLFanumTaxLSkibidiLKaiCenatLSkibidiLRizzLRobloxLSigmaLRizzLMewingLOhioLRizzLRobloxLRizzLSkibidiLRizzLKaiCenatLGyattLSkibidiLFanumTaxLMewingLOhioLSkibidiLOhioLOhioLRizz",
		"OhioLRizzLMewingLKaiCenatLSigmaLFanumTaxLSkibidiLOhioLFanumTaxLGyattLSigmaLRobloxLOhioLKaiCenatLOhioLGyattLSigmaLGyattLRobloxLSigmaLKaiCenatLKaiCenatLSkibidiLKaiCenatLGyattLSkibidiLSkibidiLOhioLOhioLOhioLSkibidiLRizzLRizzLKaiCenatLSkibidiLSkibidiLMewingLGyattLSigmaLKaiCenatLMewingLFanumTaxLOhio",
		"GyattLRizzLMewingLOhioLSigmaLRobloxLMewingLOhioLFanumTaxLKaiCenatLMewingLRizzLOhioLMewingLRobloxLSkibidiLRobloxLSigmaLOhioLGyattLRobloxLOhioLMewingLFanumTaxLSkibidiLFanumTaxLRobloxLRizzLSkibidiLGyattLRobloxLSigmaLRizzLOhioLGyattLMewingLFanumTaxLMewingLFanumTaxLSigmaLSigmaLGyattLGyattLKaiCenat",
		"MewingLRizzLKaiCenatLSigmaLFanumTaxLSigmaLSkibidiLKaiCenatLKaiCenatLRizzLKaiCenatLSkibidiLMewingLMewingLFanumTaxLFanumTaxLGyattLSkibidiLMewingLSigmaLFanumTaxLGyattLMewingLMewingLMewingLSigmaLRobloxLMewingLRobloxLRobloxLKaiCenatLRizzLSigmaLMewingLFanumTaxLRobloxLOhioLSigmaLFanumTaxLFanumTaxLRizzLMewingLOhioLFanumTax",
		"SkibidiLSkibidiLSigmaLSkibidiLGyattLMewingLRizzLRobloxLMewingLSigmaLRizzLKaiCenatLRizzLMewingLOhioLKaiCenatLRizzLMewingLSigmaLOhioLGyattLMewingLGyattLMewingLMewingLOhioLRobloxLFanumTaxLRizzLSigmaLOhioLRobloxLSigmaLGyattLGyattLSkibidiLSkibidiLKaiCenatLOhioLGyattLSigmaLRizzLOhioLFanumTaxLRoblox",
		"MewingLFanumTaxLSigmaLSkibidiLFanumTaxLGyattLSkibidiLOhioLKaiCenatLRizzLSigmaLRobloxLMewingLOhioLSkibidiLKaiCenatLMewingLSkibidiLSkibidiLGyattLGyattLKaiCenatLOhioLRizzLRizzLSkibidiLSkibidiLSigmaLFanumTaxLRobloxLKaiCenatLMewingLOhioLGyattLSkibidiLKaiCenatLGyattLKaiCenatLSigmaLSkibidiLKaiCenatLFanumTaxLOhioLMewingLRoblox",
		"FanumTaxLMewingLRobloxLKaiCenatLMewingLMewingLFanumTaxLKaiCenatLOhioLRobloxLSkibidiLGyattLSigmaLMewingLFanumTaxLFanumTaxLFanumTaxLMewingLKaiCenatLMewingLRobloxLKaiCenatLOhioLGyattLGyattLRizzLGyattLFanumTaxLKaiCenatLRizzLRizzLSigmaLRizzLSkibidiLSigmaLSkibidiLGyattLRobloxLKaiCenatLFanumTaxLRobloxLFanumTaxLFanumTaxLSkibidiLSigma",
		"SigmaLFanumTaxLOhioLRizzLMewingLRobloxLSigmaLSigmaLSkibidiLRizzLRobloxLRizzLKaiCenatLKaiCenatLRizzLSigmaLGyattLRizzLSigmaLFanumTaxLMewingLMewingLSigmaLGyattLOhioLGyattLKaiCenatLGyattLMewingLGyattLGyattLRizzLFanumTaxLSkibidiLGyattLRizzLMewingLSkibidiLMewingLRobloxLSigmaLGyattLSigmaLOhioLKaiCenatLKaiCenat",
		"GyattLKaiCenatLOhioLGyattLMewingLSkibidiLFanumTaxLSkibidiLSigmaLFanumTaxLSigmaLMewingLRizzLRizzLSigmaLSkibidiLSkibidiLFanumTaxLMewingLGyattLRizzLRizzLRizzLMewingLSigmaLOhioLKaiCenatLMewingLSigmaLOhioLSigmaLFanumTaxLSigmaLRizzLSkibidiLOhioLGyattLFanumTaxLRobloxLRobloxLMewingLKaiCenatLOhioLSigmaLMewing",
		"KaiCenatLMewingLFanumTaxLKaiCenatLOhioLRizzLKaiCenatLSkibidiLGyattLFanumTaxLRizzLMewingLKaiCenatLSkibidiLGyattLRobloxLFanumTaxLRizzLMewingLKaiCenatLSigmaLOhioLOhioLKaiCenatLRobloxLSigmaLRobloxLKaiCenatLOhioLFanumTaxLSigmaLRobloxLKaiCenatLSkibidiLRobloxLMewingLOhioLRizzLFanumTaxLMewingLMewingLSkibidiLFanumTaxLRobloxLSkibidiLSigma",
		"SigmaLFanumTaxLFanumTaxLMewingLSkibidiLOhioLRizzLSigmaLGyattLOhioLSkibidiLSigmaLFanumTaxLRobloxLRizzLSigmaLRobloxLSkibidiLKaiCenatLKaiCenatLMewingLMewingLRobloxLRobloxLRizzLKaiCenatLMewingLFanumTaxLMewingLRobloxLGyattLOhioLKaiCenatLSigmaLSkibidiLRizzLSigmaLSkibidiLGyattLRizzLKaiCenatLSkibidiLKaiCenatLSigmaLFanumTaxLGyattLRoblox",
		"MewingLGyattLKaiCenatLSigmaLMewingLRizzLSigmaLRobloxLRobloxLFanumTaxLSigmaLSkibidiLSkibidiLRobloxLSigmaLRobloxLRobloxLGyattLGyattLKaiCenatLMewingLKaiCenatLFanumTaxLGyattLRobloxLSigmaLSigmaLSigmaLMewingLRizzLRizzLOhioLSkibidiLKaiCenatLSigmaLRobloxLGyattLFanumTaxLKaiCenatLFanumTaxLSkibidiLFanumTaxLSigmaLSigmaLSkibidiLSigmaLSkibidi",
		"OhioLFanumTaxLMewingLRizzLSkibidiLGyattLSigmaLRizzLSkibidiLSkibidiLGyattLFanumTaxLKaiCenatLMewingLKaiCenatLFanumTaxLFanumTaxLGyattLGyattLSkibidiLRizzLOhioLGyattLKaiCenatLRobloxLFanumTaxLMewingLRobloxLOhioLMewingLFanumTaxLMewingLRobloxLOhioLRobloxLRizzLRobloxLGyattLMewingLOhioLRizzLFanumTaxLRizzLKaiCenatLGyattLOhio",
		"SigmaLSigmaLMewingLSigmaLSkibidiLFanumTaxLRizzLFanumTaxLSigmaLKaiCenatLOhioLKaiCenatLOhioLKaiCenatLKaiCenatLRobloxLFanumTaxLMewingLMewingLSkibidiLOhioLMewingLSigmaLRobloxLSkibidiLOhioLKaiCenatLGyattLMewingLSigmaLKaiCenatLKaiCenatLFanumTaxLSkibidiLKaiCenatLSigmaLSigmaLSigmaLRobloxLGyattLGyattLSkibidiLSkibidiLMewingLMewingLOhioLFanumTax",
		"KaiCenatLMewingLFanumTaxLRobloxLRizzLSkibidiLGyattLGyattLGyattLOhioLRizzLFanumTaxLMewingLSigmaLRizzLOhioLRobloxLRobloxLSigmaLOhioLSkibidiLSigmaLRobloxLSigmaLMewingLSkibidiLRizzLSigmaLRizzLKaiCenatLKaiCenatLRizzLRobloxLRizzLRizzLRobloxLKaiCenatLKaiCenatLOhioLRizzLSigmaLSigmaLMewingLMewingLFanumTaxLRobloxLRoblox",
		"SigmaLFanumTaxLSkibidiLKaiCenatLOhioLKaiCenatLKaiCenatLMewingLRizzLFanumTaxLRizzLRizzLKaiCenatLRobloxLMewingLSigmaLRobloxLRizzLOhioLSigmaLOhioLOhioLSigmaLRizzLRizzLSigmaLRizzLFanumTaxLMewingLFanumTaxLGyattLMewingLGyattLKaiCenatLGyattLMewingLKaiCenatLSigmaLMewingLRizzLSkibidiLRobloxLFanumTaxLSigmaLFanumTaxLSigmaLSigma",
		"SigmaLRizzLGyattLMewingLSkibidiLSkibidiLKaiCenatLSkibidiLKaiCenatLMewingLGyattLSkibidiLOhioLGyattLMewingLOhioLMewingLSigmaLFanumTaxLFanumTaxLFanumTaxLRobloxLOhioLRobloxLRizzLFanumTaxLRobloxLMewingLKaiCenatLRizzLOhioLRizzLSkibidiLRizzLSkibidiLMewingLRizzLGyattLMewingLGyattLSigmaLRizzLSkibidiLSkibidiLFanumTaxLSkibidiLOhioLSkibidiLMewing",
		"MewingLRizzLFanumTaxLFanumTaxLGyattLRobloxLGyattLKaiCenatLGyattLSigmaLKaiCenatLRobloxLSigmaLRobloxLMewingLOhioLFanumTaxLOhioLGyattLRobloxLKaiCenatLGyattLOhioLFanumTaxLGyattLRizzLRobloxLRobloxLGyattLSkibidiLOhioLOhioLKaiCenatLGyattLMewingLOhioLOhioLKaiCenatLRobloxLGyattLRizzLKaiCenatLKaiCenatLRizzLKaiCenatLRobloxLGyattLOhioLRoblox",
		"KaiCenatLGyattLFanumTaxLGyattLOhioLRizzLGyattLRobloxLSigmaLRobloxLFanumTaxLSigmaLSigmaLSkibidiLFanumTaxLRizzLMewingLOhioLMewingLRizzLSkibidiLSigmaLMewingLGyattLSkibidiLRobloxLFanumTaxLFanumTaxLSkibidiLSigmaLMewingLRobloxLGyattLOhioLSkibidiLKaiCenatLRobloxLOhioLGyattLFanumTaxLMewingLSkibidiLRizzLSigmaLMewingLMewingLSigmaLFanumTaxLRizz",
		"SigmaLMewingLSkibidiLFanumTaxLKaiCenatLSkibidiLFanumTaxLMewingLKaiCenatLOhioLFanumTaxLRizzLSigmaLRobloxLRizzLMewingLFanumTaxLMewingLMewingLFanumTaxLSkibidiLFanumTaxLKaiCenatLRobloxLRobloxLOhioLKaiCenatLMewingLSkibidiLSkibidiLOhioLSkibidiLSigmaLFanumTaxLSkibidiLGyattLRobloxLSkibidiLMewingLMewingLSkibidiLGyattLRobloxLGyattLGyattLKaiCenatLGyattLRizzLMewingLRoblox",
		"MewingLRizzLFanumTaxLOhioLFanumTaxLGyattLSigmaLFanumTaxLGyattLSigmaLRizzLSigmaLKaiCenatLKaiCenatLGyattLSigmaLMewingLOhioLSigmaLMewingLRobloxLGyattLKaiCenatLMewingLOhioLFanumTaxLFanumTaxLRizzLMewingLMewingLRizzLRobloxLSigmaLGyattLGyattLOhioLSigmaLFanumTaxLSkibidiLSigmaLOhioLGyattLOhioLSigmaLKaiCenatLRobloxLSkibidiLSigmaLSigma",
		"MewingLOhioLRizzLGyattLFanumTaxLMewingLFanumTaxLRobloxLKaiCenatLRobloxLOhioLSigmaLKaiCenatLMewingLOhioLSkibidiLFanumTaxLSigmaLGyattLRobloxLSigmaLRobloxLSkibidiLGyattLSigmaLOhioLOhioLSigmaLGyattLFanumTaxLRizzLFanumTaxLGyattLOhioLSigmaLFanumTaxLFanumTaxLFanumTaxLRizzLSigmaLGyattLOhioLOhioLMewingLSigmaLSkibidiLRizzLOhioLKaiCenat",
		"SigmaLSkibidiLFanumTaxLMewingLSigmaLFanumTaxLGyattLMewingLSigmaLOhioLSigmaLMewingLRizzLRizzLMewingLGyattLKaiCenatLRizzLFanumTaxLKaiCenatLSigmaLKaiCenatLRobloxLGyattLRobloxLRobloxLSigmaLKaiCenatLOhioLSigmaLSigmaLMewingLKaiCenatLSigmaLFanumTaxLMewingLFanumTaxLRobloxLSkibidiLFanumTaxLMewingLGyattLKaiCenatLFanumTaxLSkibidiLKaiCenatLRobloxLOhioLSkibidiLSigmaLSkibidi",
		"SigmaLKaiCenatLFanumTaxLRizzLKaiCenatLOhioLSigmaLRobloxLRizzLSkibidiLMewingLOhioLRobloxLSkibidiLRizzLRobloxLKaiCenatLKaiCenatLFanumTaxLSkibidiLRizzLRizzLKaiCenatLRizzLRobloxLGyattLGyattLRizzLRizzLRizzLRizzLKaiCenatLKaiCenatLMewingLFanumTaxLKaiCenatLFanumTaxLGyattLKaiCenatLSigmaLOhioLSigmaLRobloxLFanumTaxLFanumTaxLOhioLGyattLRobloxLFanumTaxLRobloxLKaiCenat",
		"MewingLGyattLRobloxLRobloxLFanumTaxLGyattLFanumTaxLRizzLSkibidiLOhioLGyattLFanumTaxLOhioLSigmaLRizzLKaiCenatLFanumTaxLOhioLRobloxLKaiCenatLOhioLMewingLGyattLRobloxLSigmaLSigmaLRobloxLMewingLSigmaLKaiCenatLFanumTaxLSkibidiLGyattLRizzLGyattLKaiCenatLRizzLGyattLFanumTaxLKaiCenatLFanumTaxLFanumTaxLOhioLRobloxLFanumTaxLOhioLKaiCenatLRobloxLFanumTaxLOhioLSigma",
		"SigmaLSkibidiLSigmaLSigmaLRobloxLRobloxLRizzLOhioLFanumTaxLKaiCenatLRizzLGyattLMewingLSkibidiLKaiCenatLSkibidiLSigmaLMewingLFanumTaxLRobloxLOhioLKaiCenatLRizzLFanumTaxLSigmaLGyattLOhioLMewingLFanumTaxLMewingLFanumTaxLFanumTaxLKaiCenatLRizzLFanumTaxLSkibidiLRizzLRobloxLFanumTaxLGyattLSkibidiLRizzLSkibidiLRizzLRobloxLFanumTaxLKaiCenatLOhioLMewingLMewingLMewingLRizz",
		"SigmaLGyattLFanumTaxLFanumTaxLRobloxLMewingLGyattLKaiCenatLOhioLFanumTaxLSigmaLSkibidiLFanumTaxLSigmaLOhioLMewingLFanumTaxLGyattLFanumTaxLMewingLFanumTaxLRizzLRizzLRizzLGyattLGyattLRobloxLOhioLRobloxLFanumTaxLRizzLRizzLFanumTaxLGyattLRizzLRizzLSkibidiLMewingLOhioLRobloxLSigmaLRobloxLKaiCenatLRizzLRizzLMewingLRizzLOhioLRizzLRizzLKaiCenat",
		"MewingLKaiCenatLKaiCenatLOhioLSkibidiLFanumTaxLGyattLRizzLSigmaLOhioLSigmaLOhioLMewingLOhioLSigmaLRizzLRizzLMewingLSkibidiLSigmaLGyattLOhioLGyattLFanumTaxLMewingLGyattLSigmaLSigmaLKaiCenatLSkibidiLKaiCenatLGyattLMewingLKaiCenatLOhioLOhioLKaiCenatLKaiCenatLRobloxLSigmaLMewingLRizzLRizzLRizzLGyattLGyattLRobloxLFanumTaxLFanumTaxLGyattLSkibidiLSigma",
		"OhioLFanumTaxLFanumTaxLRizzLSigmaLFanumTaxLOhioLGyattLRizzLMewingLFanumTaxLOhioLFanumTaxLSkibidiLOhioLMewingLGyattLGyattLOhioLSigmaLFanumTaxLRizzLRobloxLSkibidiLOhioLOhioLMewingLRizzLFanumTaxLSkibidiLKaiCenatLGyattLMewingLKaiCenatLRobloxLSkibidiLRobloxLKaiCenatLFanumTaxLOhioLRizzLRobloxLGyattLSigmaLFanumTaxLOhioLSigmaLMewingLGyattLKaiCenatLSkibidiLRizz",
		"SkibidiLFanumTaxLFanumTaxLRobloxLSigmaLKaiCenatLSigmaLMewingLKaiCenatLMewingLKaiCenatLFanumTaxLSigmaLKaiCenatLSkibidiLFanumTaxLSigmaLRizzLRizzLRizzLSigmaLKaiCenatLRizzLRobloxLRizzLOhioLRizzLSkibidiLRobloxLFanumTaxLKaiCenatLRizzLKaiCenatLRobloxLMewingLSkibidiLOhioLMewingLSkibidiLOhioLSkibidiLGyattLRobloxLMewingLMewingLSkibidiLRobloxLOhioLMewingLFanumTaxLSigmaLFanumTax",
		"SkibidiLRizzLOhioLRizzLRizzLOhioLKaiCenatLMewingLOhioLKaiCenatLRizzLOhioLRobloxLOhioLMewingLGyattLGyattLKaiCenatLKaiCenatLSigmaLOhioLMewingLSkibidiLGyattLRizzLGyattLGyattLFanumTaxLGyattLSigmaLRobloxLFanumTaxLKaiCenatLOhioLRobloxLMewingLKaiCenatLKaiCenatLGyattLRobloxLFanumTaxLSkibidiLSigmaLSigmaLMewingLRobloxLGyattLOhioLSigmaLSkibidiLRizzLRobloxLKaiCenat",
		"SigmaLMewingLSkibidiLGyattLOhioLMewingLOhioLOhioLFanumTaxLKaiCenatLGyattLGyattLOhioLGyattLRobloxLMewingLSkibidiLRizzLSigmaLKaiCenatLMewingLSkibidiLGyattLFanumTaxLSkibidiLSigmaLKaiCenatLRobloxLOhioLSigmaLGyattLRobloxLFanumTaxLOhioLMewingLMewingLOhioLSigmaLSkibidiLOhioLOhioLRobloxLKaiCenatLGyattLKaiCenatLOhioLRizzLKaiCenatLSigmaLSigmaLOhioLRizzLRizz",
		"GyattLOhioLRobloxLKaiCenatLFanumTaxLOhioLGyattLGyattLMewingLSkibidiLMewingLOhioLOhioLFanumTaxLSkibidiLMewingLKaiCenatLKaiCenatLRizzLRobloxLOhioLRobloxLOhioLKaiCenatLRobloxLSigmaLMewingLOhioLSigmaLSkibidiLMewingLRizzLFanumTaxLRobloxLFanumTaxLOhioLSkibidiLMewingLRizzLRobloxLGyattLFanumTaxLOhioLOhioLOhioLGyattLMewingLMewingLMewingLGyattLKaiCenatLSkibidi",
		"OhioLOhioLGyattLRobloxLRobloxLSigmaLKaiCenatLSigmaLMewingLFanumTaxLFanumTaxLSigmaLSkibidiLKaiCenatLFanumTaxLRizzLRobloxLFanumTaxLOhioLRobloxLFanumTaxLMewingLFanumTaxLRobloxLOhioLRizzLRizzLRizzLOhioLSkibidiLSkibidiLKaiCenatLMewingLKaiCenatLSigmaLKaiCenatLSkibidiLFanumTaxLSkibidiLFanumTaxLMewingLGyattLRobloxLFanumTaxLSigmaLSkibidiLSigmaLFanumTaxLFanumTaxLKaiCenatLFanumTaxLFanumTaxLMewing",
		"OhioLFanumTaxLRizzLKaiCenatLSigmaLGyattLRobloxLSkibidiLGyattLSkibidiLSkibidiLMewingLRobloxLRobloxLFanumTaxLMewingLMewingLGyattLMewingLRizzLSkibidiLOhioLFanumTaxLGyattLSigmaLKaiCenatLRobloxLMewingLSkibidiLMewingLKaiCenatLGyattLGyattLSkibidiLRobloxLGyattLRobloxLGyattLSkibidiLRobloxLRizzLSkibidiLRobloxLFanumTaxLKaiCenatLGyattLGyattLGyattLOhioLRizzLKaiCenatLSigmaLMewingLKaiCenat",
		"FanumTaxLOhioLRobloxLMewingLSigmaLOhioLMewingLGyattLGyattLRizzLOhioLSigmaLKaiCenatLRizzLOhioLGyattLRobloxLRobloxLFanumTaxLSigmaLRizzLRobloxLMewingLSigmaLGyattLSkibidiLSkibidiLSkibidiLFanumTaxLFanumTaxLGyattLGyattLOhioLFanumTaxLSigmaLKaiCenatLFanumTaxLRizzLGyattLRizzLOhioLGyattLGyattLSigmaLSigmaLFanumTaxLMewingLRizzLSigmaLOhioLSkibidiLGyattLMewingLRizz",
	}

	b := []string{
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

	for c := 0; c < len(a); c++ {
		d := strings.Split(a[c], "L")
		e := big.NewInt(0)
		for f := 0; f < len(d); f++ {
			for g := 0; g < len(b); g++ {
				if d[f] == b[g] {
					e.Mul(e, big.NewInt(int64(len(b))))
					e.Add(e, big.NewInt(int64(g)))
				}
			}
		}
		h := big.NewInt(0)
		h.Mul(e, big.NewInt(9))
		h.Add(e, big.NewInt(6))
		h.Mod(h, big.NewInt(256))
		fmt.Printf("%c", h.Int64())
	}
	fmt.Println()
}