import { Module } from '@nestjs/common';
import { AppController } from './app.controller';
import { AppService } from './app.service';
import { CqrsModule } from '@nestjs/cqrs';
import { TarantoolRepository } from './repositories/tarantool.repository';
import { GetListPesertaHandler, GetPesertabyIDHandler, GetPesertaHandler } from './queries/handlers/app.query';
import { TarantoolConnection } from './config/tarantool.connection';
import { ConfigService } from '@nestjs/config';

@Module({
  imports: [CqrsModule],
  controllers: [AppController],
  providers: [
  AppService,
  TarantoolRepository,
  GetListPesertaHandler,
  GetPesertabyIDHandler,
  GetPesertaHandler,
  TarantoolConnection,
  TarantoolRepository,
  ConfigService,
  ],
})
export class AppModule {}
