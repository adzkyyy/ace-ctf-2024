import { Body, Controller, Get, Param, Post, Render, Req, ValidationPipe } from '@nestjs/common';
import { AppService } from './app.service';
import { ResponseApi } from './interfaces/response';
import { flagRequest } from './dto/app.req';
import { RealIP } from 'nestjs-real-ip';
import * as ipRangeCheck from 'ip-range-check';

@Controller()
export class AppController {
  constructor(
    private readonly appService: AppService
  ) {}

  @Get()
  @Render('index')
  async getIndex(){
  }

  @Get('api/v1/list_peserta')
  async getListPeserta(): Promise<ResponseApi<string>>{
    try {
      const peserta = await this.appService.getListPeserta();
      if (!peserta.status) return {code: 400, message: 'Not Found', data: null}
      return {code: 200, message: 'Success', data: peserta.data}
    } catch (error) {
      return {code: 500, message: 'Internal Server Error', data: null}
    }
  }

  @Get('api/v1/pesertabyid/:id')
  async getPesertabyID(@Param('id') id: number): Promise<ResponseApi<string>>{
    try {
      const result = await this.appService.getPesertabyID(id);
      if (!result.status) return {code: 400, message: 'Not Found', data: null}
      return {code: 200, message: 'Success', data: result.data}
    } catch (error) {
      return {code: 500, message: 'Internal Server Error', data: null}
    }
  }

  @Get('api/v1/peserta/:username')
  async getPeserta(@Param('username') username: string): Promise<ResponseApi<string>>{
    try {
      const result = await this.appService.getPeserta({username});
      if (!result.status) return {code: 400, message: 'Not Found', data: null}
      return {code: 200, message: 'Success', data: result.data}
    } catch (error) {
      return {code: 500, message: 'Internal Server Error', data: null}
    }
  }

  @Post('api/v1/flag')
  async getFlag(
    @Body(new ValidationPipe()) req: flagRequest, 
    @RealIP() ip: string): Promise<ResponseApi<string>>{
    try {
      console.log(ip, ipRangeCheck(ip, '172.20.0.4/30'))
      if (!ipRangeCheck(ip, '172.20.0.4/30')) return {code: 403, message: 'Forbidden', data: null}
      const result = await this.appService.flag(req.flag);
      return { code: 200, message: 'Flag nya ketemu!', data: result}
    } catch(error) {
      return {code: 500, message: 'Internal Server Error', data: null}
    }
  }
}
