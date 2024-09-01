import { IsDefined, IsString } from "@nestjs/class-validator";

export class flagRequest {
    @IsDefined()
    @IsString()
    flag: string
}