import { Injectable } from '@nestjs/common';
import { QueryBus } from '@nestjs/cqrs';
import { GetListPesertaQuery, GetPesertabyIDQuery, GetPesertaQuery } from './queries/impl/app.impl';
import { ResponseTemplate } from './interfaces/response';
import { userdetail } from './dto/app.res';

@Injectable()
export class AppService {
  constructor(
    private readonly queryBus: QueryBus,
  ){}

  async getPesertabyID(param: number): Promise<ResponseTemplate<string>> {
    try {
      return await this.queryBus.execute(new GetPesertabyIDQuery(param));
    } catch (error){
      return {
        status: false,
        data: null
      }
    }
  }

  async getPeserta(param: userdetail): Promise<ResponseTemplate<string>> {
    try {
      return await this.queryBus.execute(new GetPesertaQuery(param.username));
    } catch (error){
      return {
        status: false,
        data: null
      }
    }
  }

  async getListPeserta(): Promise<ResponseTemplate<string>> {
    try {
      return await this.queryBus.execute(new GetListPesertaQuery());
    } catch (error) {
      return {
        status: false, 
        data: null
      }
    }
  }

  async flag(req: string): Promise<string> {
    return req
  }
}
