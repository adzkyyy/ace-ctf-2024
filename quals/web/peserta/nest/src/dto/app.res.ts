import { IsDefined, IsString } from "@nestjs/class-validator";

export class userdetail {
    @IsDefined()
    @IsString()
    username: string
}