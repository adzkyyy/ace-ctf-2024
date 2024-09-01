'use client'
import React, { useEffect, useState } from 'react';
import Link from 'next/link';
import { join } from 'path';

interface GitHubContent {
    name: string;
    type: 'file' | 'dir';
    path: string;
}


interface GitHubDirectoryListProps {
    contents: GitHubContent[];
    handleDirectoryClick: (directory: string) => void;
}

const GitHubDirectoryList: React.FC<GitHubDirectoryListProps> = ({
    contents,
    handleDirectoryClick,
}) => (
    <ul className="menu menu-xs bg-neutral rounded-lg w-full">
        {contents.map((item) => (
            <GitHubDirectoryItem key={item.name} item={item} handleDirectoryClick={handleDirectoryClick} />
        ))}
    </ul>
);

interface GitHubDirectoryItemProps {
    item: GitHubContent;
    handleDirectoryClick: (directory: string) => void;
}

const GitHubDirectoryItem: React.FC<GitHubDirectoryItemProps> = ({ item, handleDirectoryClick }) => {
    if (item.type === 'file' && !item.name.includes(".md")) {
        return
    }
    return <>
        <li className="mb-2 cursor-pointer" onClick={() => item.type === 'dir' && handleDirectoryClick(item.path)}>
            {item.type === 'dir' ? (
                <strong className="flex items-center text-white">
                    {item.name}
                </strong>
            ) : (
                <Link href={join('/article/', item.path)}>
                    <span className="flex items-center text-white">
                        {item.name}
                    </span>
                </Link>
            )}
        </li>
    </>
};

interface GitHubDirectoryListingProps {
    repoOwner: string;
    repoName: string;
    pathInRepo?: string;
}

const GitHubDirectoryListing: React.FC<GitHubDirectoryListingProps> = ({ repoOwner, repoName, pathInRepo = '' }) => {
    const [contents, setContents] = useState<GitHubContent[]>([]);
    const [currentPath, setCurrentPath] = useState<string | null>(null);
    const [loading, setLoading] = useState<boolean>(false);

    const handleDirectoryClick = async (directory: string) => {
        const newPath = pathInRepo ? `${pathInRepo}/${directory}` : directory;
        try {
            setLoading(true);
            const response = await fetch(`https://api.github.com/repos/${repoOwner}/${repoName}/contents/${newPath}?ref=main`);

            if (!response.ok) {
                throw new Error(`GitHub API request failed with status ${response.status}`);
            }

            const data: GitHubContent[] = await response.json();
            setContents(data);
            setCurrentPath(newPath);
        } catch (error) {
            //@ts-ignore
            console.error('Error fetching GitHub content:', error.message);
        } finally {
            setLoading(false);
        }
    };

    const handleBackButtonClick = () => {
        const newPath = currentPath?.split('/').slice(0, -1).join('/') || '';
        setCurrentPath(newPath);
        fetchData(newPath);
    };

    const fetchData = async (path: string) => {
        try {
            const response = await fetch(`https://api.github.com/repos/${repoOwner}/${repoName}/contents/${path}?ref=main`);

            if (!response.ok) {
                throw new Error(`GitHub API request failed with status ${response.status}`);
            }

            const data: GitHubContent[] = await response.json();
            setContents(data);
        } catch (error) {
            //@ts-ignore
            console.error('Error fetching GitHub content:', error.message);
        }
    };

    useEffect(() => {
        fetchData(pathInRepo);
        setCurrentPath(pathInRepo);
    // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [repoOwner, repoName, pathInRepo]);

    const renderLoadingSkeleton = () => (
        <div className="flex flex-col gap-4 w-96">
            <div className="skeleton h-32 w-full"></div>
        </div>
    );

    const renderContent = () => (
        <>
            <GitHubDirectoryList contents={contents} handleDirectoryClick={handleDirectoryClick} />
            {currentPath !== '' && (
                <button className="btn btn-neutral w-full mt-3" onClick={handleBackButtonClick}>
                    Back
                </button>
            )}
        </>
    );

    return <div className="w-96">{loading ? renderLoadingSkeleton() : renderContent()}</div>;
};

export default GitHubDirectoryListing
