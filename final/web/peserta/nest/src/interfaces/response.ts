export interface ResponseApi<T> {
    code: number;
    message: string;
    data: T | {};
  }
  
  export interface ResponseTemplate<T> {
    status: boolean;
    data: T;
  }
  