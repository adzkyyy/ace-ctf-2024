import { Injectable } from '@nestjs/common';
import { ConfigService } from '@nestjs/config';
import TarantoolDriver = require('tarantool-driver');

let instance: TarantoolConnection | null = null;

type CallName =
  | 'select'
  | 'delete'
  | 'insert'
  | 'replace'
  | 'update'
  | 'eval'
  | 'call'
  | 'upsert'
  | 'instance';

@Injectable()
export class TarantoolConnection {
  private connection: TarantoolDriver;
  private ready_promise: Promise<void | false>;
  constructor(private readonly configService: ConfigService) {
    const host = '192.168.50.102';
    const port = 3301;

    console.log(host, port);

    // const username = 'guest';
    // const password = '';

    this.connection = new TarantoolDriver({ host, port });

    this.ready_promise = new Promise((resolve, reject) => {
      this.connection
        .connect()
        // .then(() => this.connection.auth(username, password))
        .then(() => resolve())
        .catch(() => resolve(false));
    });
  }

  private makeCall(call_name: CallName, args: any[]): Promise<any> {
    return this.ready_promise
      .then(() => {
        const call_time = Date.now();
        return this.connection[call_name](...args).then((res: any) => {
          // No newrelic tracking here
          const time_taken = Date.now() - call_time;
          // Optionally, you might want to log the call time or other metrics here
          console.log(`Call to ${call_name} took ${time_taken}ms`);
          return res;
        });
      })
      .catch((error: Error) => {
        // Ensure that error.message is defined and a string
        const errorMessage = error.message || '';
        if (errorMessage.indexOf('connect') >= 0) {
          // Assuming 'instance' is a variable that needs to be set to null on connect errors
          instance = null;
        }
        return Promise.reject(error);
      });
  }

  public select(...args: any[]): Promise<any> {
    return this.makeCall('select', args);
  }

  public delete(...args: any[]): Promise<any> {
    return this.makeCall('delete', args);
  }

  public insert(...args: any[]): Promise<any> {
    return this.makeCall('insert', args);
  }

  public replace(...args: any[]): Promise<any> {
    return this.makeCall('replace', args);
  }

  public update(...args: any[]): Promise<any> {
    return this.makeCall('update', args);
  }

  public eval(...args: any[]): Promise<any> {
    return this.makeCall('eval', args);
  }

  public call(...args: any[]): Promise<any> {
    return this.makeCall('call', args);
  }

  public upsert(...args: any[]): Promise<any> {
    return this.makeCall('upsert', args);
  }

  public static instance(): TarantoolConnection {
    const configService = new ConfigService();
    if (!instance) instance = new TarantoolConnection(configService);
    return instance;
  }
}
