import GitHubDirectoryListing from "./GithubDirectoryListing";

const IndexPage: React.FC = () => {
    return (
        <div className="flex flex-col h-96 w-screen">
            <div className="self-center">
                <GitHubDirectoryListing
                    repoOwner="TCP1P"
                    repoName="TCP1P_CTF_writeup"
                />
            </div>
        </div>
    );
};

export default IndexPage;
