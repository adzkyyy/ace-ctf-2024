bits = 2024
s = 1.0214309409523419996389072775668140792472780638123011664744804962652303208200541699393378149891570070450966863022769709755297434179577837883826560921120214910131472989775792355741813011790773188743030880603484732655510046346117137724558953373808870252615365922086122178337990892435399443939072334872234533801344626177630251258361269105390398438952897128808493995364299501562930716199944186207042058952949664955037015127795765237206976000724704225525086064008429572094916225264370621127703179378623830767139815119449496352781232804792349800541846895219489236866105545743388585917703728580140808205304190173432067734768525003672234620873199718488893913045238782539327704971624568387277443353770634506378940153395981748667496593996888371408675064887004460455130173441766755902784363692359067639508093241828526606590171018932731158185222590327731708237743449887763970143251602839622984225136119911713770495593147584236702291818009265185142254620369348707637820019513421822935059030868304487790650653610112265761686614780788698567108346969774756902678509170708618050920320602154859171446434643730410045994440059455426640599387090588636374700646332935422282053108768371728486444464097228006468860515494053114562046271748708150607031313865005409007267607107063988557213429342689514718743779604867037109120799003656989599612833310345668439331732213248425541794203539127523531990593958737379576158461724851666708611293666055107651397935529968395162672675429920741211865536118796400294027146511860203683605323965417916764498682910427094992532039010648281741238541723094314063385827348198816393382527287670984714313249354898446379158533655285948636778864866404683939316535305426453126560192867671757444463528839915696916266218143365171504039376950164054687919386776177921302719458819958515090383762582160472251497755637198887534659437170723841361432285460826080060988976990730232439513450176822789675191427614922728759084923927462477974412537581919757280237398173009004061781974953338041254735165454589230645440959984080486765834834910
ss = arcsin(1/s)
pin = pi.n(bits)

L = matrix(QQ, [[1, 0, 0], [ss, 1, ss], [pin, 0, pin]])
L[:, 0] *= 2**bits
L = L.LLL()
L[:, 0] /= 2**bits

m = abs(round(L[0][-1]))
print(bytes.fromhex(hex(m)[2:]))
