export class GetListPesertaQuery {
    constructor(
        
    ) {}
}

export class GetPesertabyIDQuery {
    constructor(
        public readonly id: number
    ) {}
}

export class GetPesertaQuery {
    constructor(
        public readonly username: string
    ) {}
}