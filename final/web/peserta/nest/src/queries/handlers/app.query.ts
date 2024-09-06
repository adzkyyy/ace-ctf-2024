import { IQueryHandler, QueryHandler } from "@nestjs/cqrs";
import { GetListPesertaQuery, GetPesertabyIDQuery, GetPesertaQuery } from "../impl/app.impl";
import { ResponseTemplate } from "src/interfaces/response";
import { TarantoolRepository } from "src/repositories/tarantool.repository";

@QueryHandler(GetListPesertaQuery)
export class GetListPesertaHandler implements IQueryHandler<GetListPesertaQuery> {
    constructor(
        private readonly repository: TarantoolRepository
    ) {}

    async execute(query: GetListPesertaQuery): Promise<ResponseTemplate<any>> {
        const result = await this.repository.getListPeserta();
        if (!result) return {status: false, data: null}

        const data = []
        result.forEach(item => data.push(item));
        return {status: true, data: data}
    }
}

@QueryHandler(GetPesertabyIDQuery)
export class GetPesertabyIDHandler implements IQueryHandler<GetPesertabyIDQuery> {
    constructor(
        private readonly repository: TarantoolRepository
    ) {}

    async execute(query: GetPesertabyIDQuery): Promise<ResponseTemplate<any>> {
        const result = await this.repository.getPesertabyID(query.id);
        if (!result) return {status: false, data: null}
        return {status: true, data: result}
    }
}

@QueryHandler(GetPesertaQuery)
export class GetPesertaHandler implements IQueryHandler<GetPesertaQuery> {
    constructor(
        private readonly repository: TarantoolRepository
    ) {}

    async execute(query: GetPesertaQuery): Promise<ResponseTemplate<any>> {
        const result = await this.repository.getPeserta(query.username);
        if (!result) return {status: false, data: null}
        return {status: true, data: result}
    }
}