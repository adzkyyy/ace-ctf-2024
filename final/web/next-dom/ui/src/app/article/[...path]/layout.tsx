export default function MdxLayout({ children }: { children: React.ReactNode }) {
    return <>
        <div className="grid h-96">
            <div className="self-center w-screen flex flex-col">
                <div className="self-center">
                    <article className="prose">{children}</article>
                </div>
            </div>
        </div>
    </>
}
