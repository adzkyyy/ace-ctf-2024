import { Injectable } from "@nestjs/common";
import { TarantoolConnection } from "src/config/tarantool.connection";

@Injectable()
export class TarantoolRepository {
    constructor(
        private readonly connection: TarantoolConnection
    ) {
        this.initialize();
    }

    private async initialize() {
        await this.connection.eval(`
            function format_result(space_name, result)
                local format = box.space[space_name]:format()
                local output = {}
                for _, row in ipairs(result) do
                    local row_data = {}
                    for index, field in ipairs(format) do
                        row_data[field.name] = row[index]
                    end
                    table.insert(output, row_data)
                end
                return output
            end
        `);
    }

    async getListPeserta(): Promise<any> {
        try {
            const result = await this.connection.eval(`
                local result = box.space.users:select()
                return format_result('users', result)
                `);
            if (result[0].length == 0) return false
            return result[0]
        } catch (error) {
            return false
        }
    }

    async getPeserta(username: string): Promise<any> {
        try {
            const result = await this.connection.eval(`
                local result = box.space.users.index.username:select({${JSON.stringify(username)}})
                return format_result('users', result)
                `);
            if (result[0].length == 0) return false
            return result[0]
        } catch (error) {
            return false
        }
    }

    async getPesertabyID(id: number): Promise<any> { 
        try {
            const result = await this.connection.eval(`
                local result = box.space.users.index.primary:select(${id})
                return format_result('users', result)
                `);
            if (result[0].length == 0) return false
            return result[0]
        } catch (error) {
            return false
        }
    }
}