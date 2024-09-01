export class GetListPesertaQuery {
    constructor(
        
    ) {}
}

// NUMBER TYPE INPUT
export class GetPesertabyIDQuery {
    constructor(
        public readonly id: number
    ) {}
}

// STRING TYPE INPUT
export class GetPesertaQuery {
    constructor(
        public readonly username: string
    ) {}
}