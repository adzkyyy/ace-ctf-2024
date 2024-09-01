THREE.STLLoader=function(manager){THREE.Loader.call(this,manager)};THREE.STLLoader.prototype=Object.assign(Object.create(THREE.Loader.prototype),{constructor:THREE.STLLoader,load:function(url,onLoad,onProgress,onError){var scope=this,loader=new THREE.FileLoader(this.manager);loader.setPath(this.path);loader.setResponseType('arraybuffer');loader.setRequestHeader(this.requestHeader);loader.setWithCredentials(this.withCredentials);loader.load(url,function(text){try{onLoad(scope.parse(text))}catch(e){if(onError){onError(e)}else{console.error(e)}scope.manager.itemError(url)}},onProgress,onError)},parse:function(data){function isBinary(data){var expect,face_size,n_faces,reader;reader=new DataView(data);face_size=(32/8*3)+((32/8*3)*3)+(16/8);n_faces=reader.getUint32(80,true);expect=80+(32/8)+(n_faces*face_size);if(expect===reader.byteLength){return true}var solid=[115,111,108,105,100];for(var off=0;off<5;off++){if(matchDataViewAt(solid,reader,off))return false}return true}function matchDataViewAt(query,reader,offset){for(var i=0,il=query.length;i<il;i++){if(query[i]!==reader.getUint8(offset+i,false))return false}return true}function parseBinary(data){var reader=new DataView(data),faces=reader.getUint32(80,true),r,g,b,hasColors=false,colors,defaultR,defaultG,defaultB,alpha;for(var index=0;index<80-10;index++){if((reader.getUint32(index,false)==0x434F4C4F)&&(reader.getUint8(index+4)==0x52)&&(reader.getUint8(index+5)==0x3D)){hasColors=true;colors=new Float32Array(faces*3*3);defaultR=reader.getUint8(index+6)/255;defaultG=reader.getUint8(index+7)/255;defaultB=reader.getUint8(index+8)/255;alpha=reader.getUint8(index+9)/255}}var dataOffset=84,faceLength=12*4+2,geometry=new THREE.BufferGeometry(),vertices=new Float32Array(faces*3*3),normals=new Float32Array(faces*3*3);for(var face=0;face<faces;face++){var start=dataOffset+face*faceLength,normalX=reader.getFloat32(start,true),normalY=reader.getFloat32(start+4,true),normalZ=reader.getFloat32(start+8,true);if(hasColors){var packedColor=reader.getUint16(start+48,true);if((packedColor&0x8000)===0){r=(packedColor&0x1F)/31;g=((packedColor>>5)&0x1F)/31;b=((packedColor>>10)&0x1F)/31}else{r=defaultR;g=defaultG;b=defaultB}}for(var i=1;i<=3;i++){var vertexstart=start+i*12,componentIdx=(face*3*3)+((i-1)*3);vertices[componentIdx]=reader.getFloat32(vertexstart,true);vertices[componentIdx+1]=reader.getFloat32(vertexstart+4,true);vertices[componentIdx+2]=reader.getFloat32(vertexstart+8,true);normals[componentIdx]=normalX;normals[componentIdx+1]=normalY;normals[componentIdx+2]=normalZ;if(hasColors){colors[componentIdx]=r;colors[componentIdx+1]=g;colors[componentIdx+2]=b}}}geometry.setAttribute('position',new THREE.BufferAttribute(vertices,3));geometry.setAttribute('normal',new THREE.BufferAttribute(normals,3));if(hasColors){geometry.setAttribute('color',new THREE.BufferAttribute(colors,3));geometry.hasColors=true;geometry.alpha=alpha}return geometry}function parseASCII(data){var geometry=new THREE.BufferGeometry(),patternSolid=/solid([\s\S]*?)endsolid/g,patternFace=/facet([\s\S]*?)endfacet/g,faceCounter=0,patternFloat=/[\s]+([+-]?(?:\d*)(?:\.\d*)?(?:[eE][+-]?\d+)?)/.source,patternVertex=new RegExp('vertex'+patternFloat+patternFloat+patternFloat,'g'),patternNormal=new RegExp('normal'+patternFloat+patternFloat+patternFloat,'g'),vertices=[],normals=[],normal=new THREE.Vector3(),result,groupCount=0,startVertex=0,endVertex=0;while((result=patternSolid.exec(data))!==null){startVertex=endVertex;var solid=result[0];while((result=patternFace.exec(solid))!==null){var vertexCountPerFace=0,normalCountPerFace=0,text=result[0];while((result=patternNormal.exec(text))!==null){normal.x=parseFloat(result[1]);normal.y=parseFloat(result[2]);normal.z=parseFloat(result[3]);normalCountPerFace++}while((result=patternVertex.exec(text))!==null){vertices.push(parseFloat(result[1]),parseFloat(result[2]),parseFloat(result[3]));normals.push(normal.x,normal.y,normal.z);vertexCountPerFace++;endVertex++}if(normalCountPerFace!==1){console.error('THREE.STLLoader: Something isn\'t right with the normal of face number '+faceCounter)}if(vertexCountPerFace!==3){console.error('THREE.STLLoader: Something isn\'t right with the vertices of face number '+faceCounter)}faceCounter++}var start=startVertex,count=endVertex-startVertex;geometry.addGroup(start,count,groupCount);groupCount++}geometry.setAttribute('position',new THREE.Float32BufferAttribute(vertices,3));geometry.setAttribute('normal',new THREE.Float32BufferAttribute(normals,3));return geometry}function ensureString(buffer){if(typeof buffer!=='string'){return THREE.LoaderUtils.decodeText(new Uint8Array(buffer))}return buffer}function ensureBinary(buffer){if(typeof buffer==='string'){var array_buffer=new Uint8Array(buffer.length);for(var i=0;i<buffer.length;i++){array_buffer[i]=buffer.charCodeAt(i)&0xff}return array_buffer.buffer||array_buffer}else{return buffer}}var binData=ensureBinary(data);return isBinary(binData)?parseBinary(binData):parseASCII(ensureString(data))}});