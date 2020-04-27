!function(t){var e={};function n(r){if(e[r])return e[r].exports;var i=e[r]={i:r,l:!1,exports:{}};return t[r].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var i in t)n.d(r,i,function(e){return t[e]}.bind(null,i));return r},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=1)}([function(t,e,n){"use strict";function r(){this._azar_extendEvents=this._azar_extendEvents||{supported:{},prioritize:{},nonprioritize:{}},this.__azar_force=!("object"==typeof Node?this instanceof Node:this&&"object"==typeof this&&"number"==typeof this.nodeType&&"string"==typeof this.nodeName)}r.prototype.defineEvent=function(t){if(t instanceof Array)for(var e=0;e<t.length;++e)this._azar_extendEvents.supported[t[e]]=!0;else this._azar_extendEvents.supported[t]=!0;return this},r.prototype.isSupportedEvent=function(t){return this.__azar_force||!!this._azar_extendEvents.supported[t]},r.prototype.emit=function(t,e){this.fire.apply(this,arguments)},r.prototype.fire=function(t,e){var n=Array.prototype.slice.call(arguments,1);if(this.isSupportedEvent(t)){var r;if(this._azar_extendEvents.prioritize[t]){r=this._azar_extendEvents.prioritize[t].slice();for(var i=0;i<r.length;++i)try{r[i].wrappedCallback.apply(this,n)}catch(t){console.error(t)}}if(this._azar_extendEvents.nonprioritize[t]){r=this._azar_extendEvents.nonprioritize[t].slice();for(i=0;i<r.length;++i)try{r[i].wrappedCallback.apply(this,n)}catch(t){console.error(t)}}}else{if(!this.dispatchEvent)throw new Error("Not support event "+t);var a=new Event(t);e&&Object.assign(a,e),this.dispatchEvent(a)}return this},r.prototype.eventEmittorOnWithTime=function(t,e,n,r){if("object"==typeof e){for(var i in e)this.eventEmittorOnWithTime(t,i,e[i]);return this}if("object"==typeof n)return this.eventEmittorOnWithTime(t,e,n.callback,n.cap);for(var a=this._azar_extendEvents[r?"prioritize":"nonprioritize"][e]||[],o=-1,s=0;s<a.length;++s)if(a[s].wrappedCallback==n){o=s;break}if(o<0){var p={isOnce:t,eventName:e,callback:n,cap:!!r};p.wrappedCallback=t?function(t){p.callback.call(this,t),this.off(p.eventName,p.wrappedCallback,p.cap)}:p.callback,this.isSupportedEvent(e)||(this.addEventListener?this.addEventListener(e,p.wrappedCallback,!!r):this.attachEvent("on"+e,n,!!r)),a.push(p),this._azar_extendEvents[r?"prioritize":"nonprioritize"][e]=a}else console.warn("dupplicate event");return this},r.prototype.on=function(t,e,n){return this.eventEmittorOnWithTime(!1,t,e,n),this},r.prototype.once=function(t,e,n){return this.eventEmittorOnWithTime(!0,t,e,n),this},r.prototype.off=function(t,e,n){if("object"==typeof t){for(var r in t)this.off(r,t[r]);return this}if("object"==typeof e)return this.off(t,e.callback,e.cap);for(var i=this._azar_extendEvents[n?"prioritize":"nonprioritize"][t]||[],a=[],o=0;o<i.length;++o){var s=i[o];s.wrappedCallback==e?this.isSupportedEvent(t)||(this.removeEventListener?this.removeEventListener(s.eventName,s.wrappedCallback,!!s.call):this.detachEvent("on"+s.eventName,s.wrappedCallback,!!s.call)):a.push(s)}return this._azar_extendEvents[n?"prioritize":"nonprioritize"][t]=a,this},r.isMouseRight=function(t){var e=!1;return"which"in t?e=3==t.which:"button"in t&&(e=2==t.button),e},r.hitElement=function(t,e){for(var n=e.target;n;){if(n==t)return!0;n=n.parentElement}return!1},r.copyEvent=function(t,e){var n={};for(var r in Object.assign(n,t),n)"function"==typeof n[r]&&(n[r]=n[r].bind(t));return e&&Object.assign(n,e),n},r.eventProperties=["altKey","bubbles","button","buttons","cancelBubble","cancelable","clientX","clientY","composed","ctrlKey","currentTarget","defaultPrevented","deltaMode","deltaX","deltaY","deltaZ","detail","eventPhase","explicitOriginalTarget","isTrusted","layerX","layerY","metaKey","movementX","movementY","mozInputSource","mozPressure","offsetX","offsetY","originalTarget","pageX","pageY","rangeOffset","rangeParent","region","relatedTarget","returnValue","screenX","screenY","shiftKey","srcElement","target","timeStamp","type","deltaMode","deltaX","deltaY","deltaZ"];var i=r;var a,o=(a="qwertyuiopasdfghjklzxcvbnm",((a+=a.toUpperCase())+"_0123456789").split(""));function s(t){i.call(this),this.detach(),t&&this.attach(t),this.__azarResolveCallbacks={}}s.prototype.attach=function(t){this.host=t,this.host.addEventListener?this.host.addEventListener("message",this.__azarMessageListener.bind(this),!1):this.host.attachEvent?this.host.attachEvent("onmessage",this.__azarMessageListener.bind(this)):this.host.onmessage=this.__azarMessageListener.bind(this),this.__IFrameBridge_resolve()},s.prototype.detach=function(){this.sync=new Promise(function(t){this.__IFrameBridge_resolve=t}.bind(this))},s.fromIFrame=function(t){var e=t.contentWindow||t.contentDocument;if(e)return new s(e);var n=new s,r=function(){var e=t.contentWindow||t.contentDocument;n.attach(e)};return t.addEventListener?t.addEventListener("load",r):t.attachEvent("onload",r),n},s.getInstance=function(){return s.shareInstance||(s.shareInstance=new s(self)),s.shareInstance},Object.defineProperties(s.prototype,Object.getOwnPropertyDescriptors(i.prototype)),s.prototype.constructor=s,s.isInIFrame=function(){return top!==self},s.prototype.__azarMessageListener=function(t){this.__azarHandleData(t.data)},s.prototype.__azarHandleData=function(t){if(t.type)if("INVOKE"==t.type){var e=this.__azarRelfInvoke(t.name,t.params);e&&"function"==typeof e.then?e.then(function(e){this.__azarResolve(t.taskId,e)}.bind(this)):this.__azarResolve(t.taskId,e)}else"INVOKE_RESULT"==t.type?this.__azarResolveCallbacks[t.taskId]&&(this.__azarResolveCallbacks[t.taskId](t.result),delete this.__azarResolveCallbacks[t.taskId]):"EMIT"==t.type?this.fire.apply(this,t.params):this.fire("message",t,this)},s.prototype.__azarResolve=function(t,e){this.host.postMessage({type:"INVOKE_RESULT",taskId:t,result:e})},s.prototype.__azarRelfInvoke=function(t,e){return"function"==typeof this[t]?this[t].apply(this,e):this[t]},s.prototype.emit=function(){var t=[];return t.push.apply(t,arguments),this.sync.then(function(){this.host.postMessage({type:"EMIT",params:t})}.bind(this)),this},s.prototype.invoke=function(t){var e=[];return e.push.apply(e,arguments),e.shift(),this.sync.then(function(){var n=function(t){t>0||(t=4);var e=o;return[e[Math.random()*(e.length-10)>>0]].concat(Array(t-1).fill("").map(function(){return e[Math.random()*e.length>>0]})).join("")}(32);return this.host.postMessage({type:"INVOKE",params:e,taskId:n,name:t}),new Promise(function(t){this.__azarResolveCallbacks[n]=t}.bind(this))}.bind(this))};e.a=s},function(t,e,n){t.exports=n(2)},function(t,e,n){"use strict";n.r(e),function(t){var e=n(0);t.IFrameBridge=e.a}.call(this,n(3))},function(t,e){var n;n=function(){return this}();try{n=n||new Function("return this")()}catch(t){"object"==typeof window&&(n=window)}t.exports=n}]);
/*
WHAT: SublimeText-like Fuzzy Search

USAGE:
  fuzzysort.single('fs', 'Fuzzy Search') // {score: -16}
  fuzzysort.single('test', 'test') // {score: 0}
  fuzzysort.single('doesnt exist', 'target') // null

  fuzzysort.go('mr', ['Monitor.cpp', 'MeshRenderer.cpp'])
  // [{score: -18, target: "MeshRenderer.cpp"}, {score: -6009, target: "Monitor.cpp"}]

  fuzzysort.highlight(fuzzysort.single('fs', 'Fuzzy Search'), '<b>', '</b>')
  // <b>F</b>uzzy <b>S</b>earch
*/

// UMD (Universal Module Definition) for fuzzysort
; (function (root, UMD) {
  if (typeof define === 'function' && define.amd) define([], UMD)
  else if (typeof module === 'object' && module.exports) module.exports = UMD()
  else root.fuzzysort = UMD()
})(this, function UMD() {
  function fuzzysortNew(instanceOptions) {


    var fuzzysort = {
      workToken: '',
      single: function (search, target, options) {
        if (!search) return null
        if (!isObj(search)) search = fuzzysort.getPreparedSearch(search)

        if (!target) return null
        if (!isObj(target)) target = fuzzysort.getPrepared(target)

        var allowTypo = options && options.allowTypo !== undefined ? options.allowTypo
          : instanceOptions && instanceOptions.allowTypo !== undefined ? instanceOptions.allowTypo
            : true
        var algorithm = allowTypo ? fuzzysort.algorithm : fuzzysort.algorithmNoTypo
        return algorithm(search, target, search[0])
        // var threshold = options && options.threshold || instanceOptions && instanceOptions.threshold || -9007199254740991
        // var result = algorithm(search, target, search[0])
        // if(result === null) return null
        // if(result.score < threshold) return null
        // return result
      },

      go: function (search, targets, options) {
        if (!search) return noResults
        search = fuzzysort.prepareSearch(search)
        var searchLowerCode = search[0]

        var threshold = options && options.threshold || instanceOptions && instanceOptions.threshold || -9007199254740991
        var limit = options && options.limit || instanceOptions && instanceOptions.limit || 9007199254740991
        var allowTypo = options && options.allowTypo !== undefined ? options.allowTypo
          : instanceOptions && instanceOptions.allowTypo !== undefined ? instanceOptions.allowTypo
            : true
        var algorithm = allowTypo ? fuzzysort.algorithm : fuzzysort.algorithmNoTypo
        var resultsLen = 0; var limitedCount = 0
        var targetsLen = targets.length

        // This code is copy/pasted 3 times for performance reasons [options.keys, options.key, no keys]

        // options.keys
        if (options && options.keys) {
          var scoreFn = options.scoreFn || defaultScoreFn
          var keys = options.keys
          var keysLen = keys.length
          for (var i = targetsLen - 1; i >= 0; --i) {
            var obj = targets[i]
            var objResults = new Array(keysLen)
            for (var keyI = keysLen - 1; keyI >= 0; --keyI) {
              var key = keys[keyI]
              var target = getValue(obj, key)
              if (!target) { objResults[keyI] = null; continue }
              if (!isObj(target)) target = fuzzysort.getPrepared(target)

              objResults[keyI] = algorithm(search, target, searchLowerCode)
            }
            objResults.obj = obj // before scoreFn so scoreFn can use it
            var score = scoreFn(objResults)
            if (score === null) continue
            if (score < threshold) continue
            objResults.score = score
            if (resultsLen < limit) { q.add(objResults); ++resultsLen }
            else {
              ++limitedCount
              if (score > q.peek().score) q.replaceTop(objResults)
            }
          }

          // options.key
        } else if (options && options.key) {
          var key = options.key
          for (var i = targetsLen - 1; i >= 0; --i) {
            var obj = targets[i]
            var target = getValue(obj, key)
            if (!target) continue
            if (!isObj(target)) target = fuzzysort.getPrepared(target)

            var result = algorithm(search, target, searchLowerCode)
            if (result === null) continue
            if (result.score < threshold) continue

            // have to clone result so duplicate targets from different obj can each reference the correct obj
            result = { target: result.target, _targetLowerCodes: null, _nextBeginningIndexes: null, score: result.score, indexes: result.indexes, obj: obj } // hidden

            if (resultsLen < limit) { q.add(result); ++resultsLen }
            else {
              ++limitedCount
              if (result.score > q.peek().score) q.replaceTop(result)
            }
          }

          // no keys
        } else {
          for (var i = targetsLen - 1; i >= 0; --i) {
            var target = targets[i]
            if (!target) continue
            if (!isObj(target)) target = fuzzysort.getPrepared(target)

            var result = algorithm(search, target, searchLowerCode)
            if (result === null) continue
            if (result.score < threshold) continue
            if (resultsLen < limit) { q.add(result); ++resultsLen }
            else {
              ++limitedCount
              if (result.score > q.peek().score) q.replaceTop(result)
            }
          }
        }

        if (resultsLen === 0) return noResults
        var results = new Array(resultsLen)
        for (var i = resultsLen - 1; i >= 0; --i) results[i] = q.poll()
        results.total = resultsLen + limitedCount
        return results
      },

      goAsync: function (search, targets, options) {
        var myToken = Math.random();
        this.workToken = myToken;
        var self=this;
        var p = new Promise(function (resolve, reject) {
          if (!search) return resolve(noResults)
          search = fuzzysort.prepareSearch(search)
          var searchLowerCode = search[0]

          var q = fastpriorityqueue()
          var iCurrent = targets.length - 1
          var threshold = options && options.threshold || instanceOptions && instanceOptions.threshold || -9007199254740991
          var limit = options && options.limit || instanceOptions && instanceOptions.limit || 9007199254740991
          var allowTypo = options && options.allowTypo !== undefined ? options.allowTypo
            : instanceOptions && instanceOptions.allowTypo !== undefined ? instanceOptions.allowTypo
              : true
          var algorithm = allowTypo ? fuzzysort.algorithm : fuzzysort.algorithmNoTypo
          var resultsLen = 0; var limitedCount = 0
          function step() {
            if (self.workToken != myToken) return resolve('canceled')

            var startMs = Date.now()

            // This code is copy/pasted 3 times for performance reasons [options.keys, options.key, no keys]

            // options.keys
            if (options && options.keys) {
              var scoreFn = options.scoreFn || defaultScoreFn
              var keys = options.keys
              var keysLen = keys.length
              for (; iCurrent >= 0; --iCurrent) {
                var obj = targets[iCurrent]
                var objResults = new Array(keysLen)
                for (var keyI = keysLen - 1; keyI >= 0; --keyI) {
                  var key = keys[keyI]
                  var target = getValue(obj, key)
                  if (!target) { objResults[keyI] = null; continue }
                  if (!isObj(target)) target = fuzzysort.getPrepared(target)
                  objResults[keyI] = algorithm(search, target, searchLowerCode)
                }
                objResults.obj = obj // before scoreFn so scoreFn can use it
                var score = scoreFn(objResults)
                if (score === null) continue
                if (score < threshold) continue
                objResults.score = score
                if (resultsLen < limit) { q.add(objResults); ++resultsLen }
                else {
                  ++limitedCount
                  if (score > q.peek().score) q.replaceTop(objResults)
                }

                if (iCurrent % 1000/*itemsPerCheck*/ === 0) {
                  if (Date.now() - startMs >= 10/*asyncInterval*/) {
                    isNode ? setImmediate(step) : setTimeout(step)
                    return
                  }
                }
              }

              // options.key
            } else if (options && options.key) {
              var key = options.key
              for (; iCurrent >= 0; --iCurrent) {
                var obj = targets[iCurrent]
                var target = getValue(obj, key)
                if (!target) continue
                if (!isObj(target)) target = fuzzysort.getPrepared(target)
                var result = algorithm(search, target, searchLowerCode)
                if (result === null) continue
                if (result.score < threshold) continue

                // have to clone result so duplicate targets from different obj can each reference the correct obj
                result = { target: result.target, _targetLowerCodes: null, _nextBeginningIndexes: null, score: result.score, indexes: result.indexes, obj: obj } // hidden

                if (resultsLen < limit) { q.add(result); ++resultsLen }
                else {
                  ++limitedCount
                  if (result.score > q.peek().score) q.replaceTop(result)
                }

                if (iCurrent % 1000/*itemsPerCheck*/ === 0) {
                  if (Date.now() - startMs >= 10/*asyncInterval*/) {
                    isNode ? setImmediate(step) : setTimeout(step)
                    return
                  }
                }
              }

              // no keys
            } else {
              for (; iCurrent >= 0; --iCurrent) {
                var target = targets[iCurrent]
                if (!target) continue
                if (!isObj(target)) target = fuzzysort.getPrepared(target)
                var result = algorithm(search, target, searchLowerCode)
                if (result === null) continue
                if (result.score < threshold) continue
                if (resultsLen < limit) { q.add(result); ++resultsLen }
                else {
                  ++limitedCount
                  if (result.score > q.peek().score) q.replaceTop(result)
                }
                
                if (iCurrent % 1000/*itemsPerCheck*/ === 0) {
                  if (Date.now() - startMs >= 10/*asyncInterval*/) {
                    isNode ? setImmediate(step) : setTimeout(step)
                    return
                  }
                }
              }
            }
            if (resultsLen === 0) return resolve(noResults)
            var results = new Array(resultsLen)
            for (var i = resultsLen - 1; i >= 0; --i) results[i] = q.poll()
            results.total = resultsLen + limitedCount
            resolve(results)
          }

          isNode ? setImmediate(step) : step()
        })
        return p
      },

      highlight: function (result, hOpen, hClose) {
        if (result === null) return null
        if (hOpen === undefined) hOpen = '<b>'
        if (hClose === undefined) hClose = '</b>'
        var highlighted = ''
        var matchesIndex = 0
        var opened = false
        var target = result.target
        var targetLen = target.length
        var matchesBest = result.indexes
        for (var i = 0; i < targetLen; ++i) {
          var char = target[i]
          if (matchesBest[matchesIndex] === i) {
            ++matchesIndex
            if (!opened) {
              opened = true
              highlighted += hOpen
            }

            if (matchesIndex === matchesBest.length) {
              highlighted += char + hClose + target.substr(i + 1)
              break
            }
          } else {
            if (opened) {
              opened = false
              highlighted += hClose
            }
          }
          highlighted += char
        }

        return highlighted
      },

      prepare: function (target) {
        if (!target) return
        return { target: target, _targetLowerCodes: fuzzysort.prepareLowerCodes(target), _nextBeginningIndexes: null, score: null, indexes: null, obj: null } // hidden
      },
      prepareSlow: function (target) {
        if (!target) return
        return { target: target, _targetLowerCodes: fuzzysort.prepareLowerCodes(target), _nextBeginningIndexes: fuzzysort.prepareNextBeginningIndexes(target), score: null, indexes: null, obj: null } // hidden
      },
      prepareSearch: function (search) {
        if (!search) return
        return fuzzysort.prepareLowerCodes(search)
      },



      // Below this point is only internal code
      // Below this point is only internal code
      // Below this point is only internal code
      // Below this point is only internal code



      getPrepared: function (target) {
        if (target.length > 999) return fuzzysort.prepare(target) // don't cache huge targets
        var targetPrepared = preparedCache.get(target)
        if (targetPrepared !== undefined) return targetPrepared
        targetPrepared = fuzzysort.prepare(target)
        preparedCache.set(target, targetPrepared)
        return targetPrepared
      },
      getPreparedSearch: function (search) {
        if (search.length > 999) return fuzzysort.prepareSearch(search) // don't cache huge searches
        var searchPrepared = preparedSearchCache.get(search)
        if (searchPrepared !== undefined) return searchPrepared
        searchPrepared = fuzzysort.prepareSearch(search)
        preparedSearchCache.set(search, searchPrepared)
        return searchPrepared
      },

      algorithm: function (searchLowerCodes, prepared, searchLowerCode) {
        var targetLowerCodes = prepared._targetLowerCodes
        var searchLen = searchLowerCodes.length
        var targetLen = targetLowerCodes.length
        var searchI = 0 // where we at
        var targetI = 0 // where you at
        var typoSimpleI = 0
        var matchesSimpleLen = 0

        // very basic fuzzy match; to remove non-matching targets ASAP!
        // walk through target. find sequential matches.
        // if all chars aren't found then exit
        for (; ;) {
          var isMatch = searchLowerCode === targetLowerCodes[targetI]
          if (isMatch) {
            matchesSimple[matchesSimpleLen++] = targetI
            ++searchI; if (searchI === searchLen) break
            searchLowerCode = searchLowerCodes[typoSimpleI === 0 ? searchI : (typoSimpleI === searchI ? searchI + 1 : (typoSimpleI === searchI - 1 ? searchI - 1 : searchI))]
          }

          ++targetI; if (targetI >= targetLen) { // Failed to find searchI
            // Check for typo or exit
            // we go as far as possible before trying to transpose
            // then we transpose backwards until we reach the beginning
            for (; ;) {
              if (searchI <= 1) return null // not allowed to transpose first char
              if (typoSimpleI === 0) { // we haven't tried to transpose yet
                --searchI
                var searchLowerCodeNew = searchLowerCodes[searchI]
                if (searchLowerCode === searchLowerCodeNew) continue // doesn't make sense to transpose a repeat char
                typoSimpleI = searchI
              } else {
                if (typoSimpleI === 1) return null // reached the end of the line for transposing
                --typoSimpleI
                searchI = typoSimpleI
                searchLowerCode = searchLowerCodes[searchI + 1]
                var searchLowerCodeNew = searchLowerCodes[searchI]
                if (searchLowerCode === searchLowerCodeNew) continue // doesn't make sense to transpose a repeat char
              }
              matchesSimpleLen = searchI
              targetI = matchesSimple[matchesSimpleLen - 1] + 1
              break
            }
          }
        }

        var searchI = 0
        var typoStrictI = 0
        var successStrict = false
        var matchesStrictLen = 0

        var nextBeginningIndexes = prepared._nextBeginningIndexes
        if (nextBeginningIndexes === null) nextBeginningIndexes = prepared._nextBeginningIndexes = fuzzysort.prepareNextBeginningIndexes(prepared.target)
        var firstPossibleI = targetI = matchesSimple[0] === 0 ? 0 : nextBeginningIndexes[matchesSimple[0] - 1]

        // Our target string successfully matched all characters in sequence!
        // Let's try a more advanced and strict test to improve the score
        // only count it as a match if it's consecutive or a beginning character!
        if (targetI !== targetLen) for (; ;) {
          if (targetI >= targetLen) {
            // We failed to find a good spot for this search char, go back to the previous search char and force it forward
            if (searchI <= 0) { // We failed to push chars forward for a better match
              // transpose, starting from the beginning
              ++typoStrictI; if (typoStrictI > searchLen - 2) break
              if (searchLowerCodes[typoStrictI] === searchLowerCodes[typoStrictI + 1]) continue // doesn't make sense to transpose a repeat char
              targetI = firstPossibleI
              continue
            }

            --searchI
            var lastMatch = matchesStrict[--matchesStrictLen]
            targetI = nextBeginningIndexes[lastMatch]

          } else {
            var isMatch = searchLowerCodes[typoStrictI === 0 ? searchI : (typoStrictI === searchI ? searchI + 1 : (typoStrictI === searchI - 1 ? searchI - 1 : searchI))] === targetLowerCodes[targetI]
            if (isMatch) {
              matchesStrict[matchesStrictLen++] = targetI
              ++searchI; if (searchI === searchLen) { successStrict = true; break }
              ++targetI
            } else {
              targetI = nextBeginningIndexes[targetI]
            }
          }
        }

        { // tally up the score & keep track of matches for highlighting later
          if (successStrict) { var matchesBest = matchesStrict; var matchesBestLen = matchesStrictLen }
          else { var matchesBest = matchesSimple; var matchesBestLen = matchesSimpleLen }
          var score = 0
          var lastTargetI = -1
          for (var i = 0; i < searchLen; ++i) {
            var targetI = matchesBest[i]
            // score only goes down if they're not consecutive
            if (lastTargetI !== targetI - 1) score -= targetI
            lastTargetI = targetI
          }
          if (!successStrict) {
            score *= 1000
            if (typoSimpleI !== 0) score += -20/*typoPenalty*/
          } else {
            if (typoStrictI !== 0) score += -20/*typoPenalty*/
          }
          score -= targetLen - searchLen
          prepared.score = score
          prepared.indexes = new Array(matchesBestLen); for (var i = matchesBestLen - 1; i >= 0; --i) prepared.indexes[i] = matchesBest[i]

          return prepared
        }
      },

      algorithmNoTypo: function (searchLowerCodes, prepared, searchLowerCode) {
        var targetLowerCodes = prepared._targetLowerCodes
        var searchLen = searchLowerCodes.length
        var targetLen = targetLowerCodes.length
        var searchI = 0 // where we at
        var targetI = 0 // where you at
        var matchesSimpleLen = 0

        // very basic fuzzy match; to remove non-matching targets ASAP!
        // walk through target. find sequential matches.
        // if all chars aren't found then exit
        for (; ;) {
          var isMatch = searchLowerCode === targetLowerCodes[targetI]
          if (isMatch) {
            matchesSimple[matchesSimpleLen++] = targetI
            ++searchI; if (searchI === searchLen) break
            searchLowerCode = searchLowerCodes[searchI]
          }
          ++targetI; if (targetI >= targetLen) return null // Failed to find searchI
        }

        var searchI = 0
        var successStrict = false
        var matchesStrictLen = 0

        var nextBeginningIndexes = prepared._nextBeginningIndexes
        if (nextBeginningIndexes === null) nextBeginningIndexes = prepared._nextBeginningIndexes = fuzzysort.prepareNextBeginningIndexes(prepared.target)
        var firstPossibleI = targetI = matchesSimple[0] === 0 ? 0 : nextBeginningIndexes[matchesSimple[0] - 1]

        // Our target string successfully matched all characters in sequence!
        // Let's try a more advanced and strict test to improve the score
        // only count it as a match if it's consecutive or a beginning character!
        if (targetI !== targetLen) for (; ;) {
          if (targetI >= targetLen) {
            // We failed to find a good spot for this search char, go back to the previous search char and force it forward
            if (searchI <= 0) break // We failed to push chars forward for a better match

            --searchI
            var lastMatch = matchesStrict[--matchesStrictLen]
            targetI = nextBeginningIndexes[lastMatch]

          } else {
            var isMatch = searchLowerCodes[searchI] === targetLowerCodes[targetI]
            if (isMatch) {
              matchesStrict[matchesStrictLen++] = targetI
              ++searchI; if (searchI === searchLen) { successStrict = true; break }
              ++targetI
            } else {
              targetI = nextBeginningIndexes[targetI]
            }
          }
        }

        { // tally up the score & keep track of matches for highlighting later
          if (successStrict) { var matchesBest = matchesStrict; var matchesBestLen = matchesStrictLen }
          else { var matchesBest = matchesSimple; var matchesBestLen = matchesSimpleLen }
          var score = 0
          var lastTargetI = -1
          for (var i = 0; i < searchLen; ++i) {
            var targetI = matchesBest[i]
            // score only goes down if they're not consecutive
            if (lastTargetI !== targetI - 1) score -= targetI
            lastTargetI = targetI
          }
          if (!successStrict) score *= 1000
          score -= targetLen - searchLen
          prepared.score = score
          prepared.indexes = new Array(matchesBestLen); for (var i = matchesBestLen - 1; i >= 0; --i) prepared.indexes[i] = matchesBest[i]

          return prepared
        }
      },

      prepareLowerCodes: function (str) {
        var strLen = str.length
        var lowerCodes = [] // new Array(strLen)    sparse array is too slow
        var lower = str.toLowerCase()
        for (var i = 0; i < strLen; ++i) lowerCodes[i] = lower.charCodeAt(i)
        return lowerCodes
      },
      prepareBeginningIndexes: function (target) {
        var targetLen = target.length
        var beginningIndexes = []; var beginningIndexesLen = 0
        var wasUpper = false
        var wasAlphanum = false
        for (var i = 0; i < targetLen; ++i) {
          var targetCode = target.charCodeAt(i)
          var isUpper = targetCode >= 65 && targetCode <= 90
          var isAlphanum = isUpper || targetCode >= 97 && targetCode <= 122 || targetCode >= 48 && targetCode <= 57
          var isBeginning = isUpper && !wasUpper || !wasAlphanum || !isAlphanum
          wasUpper = isUpper
          wasAlphanum = isAlphanum
          if (isBeginning) beginningIndexes[beginningIndexesLen++] = i
        }
        return beginningIndexes
      },
      prepareNextBeginningIndexes: function (target) {
        var targetLen = target.length
        var beginningIndexes = fuzzysort.prepareBeginningIndexes(target)
        var nextBeginningIndexes = [] // new Array(targetLen)     sparse array is too slow
        var lastIsBeginning = beginningIndexes[0]
        var lastIsBeginningI = 0
        for (var i = 0; i < targetLen; ++i) {
          if (lastIsBeginning > i) {
            nextBeginningIndexes[i] = lastIsBeginning
          } else {
            lastIsBeginning = beginningIndexes[++lastIsBeginningI]
            nextBeginningIndexes[i] = lastIsBeginning === undefined ? targetLen : lastIsBeginning
          }
        }
        return nextBeginningIndexes
      },
      nonAccentVietnamese: function(s)
      {
        return s.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a")
        .replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A")
        .replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e")
        .replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E")
        .replace(/ì|í|ị|ỉ|ĩ/g, "i")
        .replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I")
        .replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o")
        .replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O")
        .replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u")
        .replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U")
        .replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y")
        .replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y")
        .replace(/đ/g, "d")
        .replace(/Đ/g, "D")
        .replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, "")
        .replace(/\u02C6|\u0306|\u031B/g, "");
      },
      cleanup: cleanup,
      new: fuzzysortNew,
    }


    return Object.assign(IFrameBridge.getInstance(), fuzzysort);
  } // fuzzysortNew

  // This stuff is outside fuzzysortNew, because it's shared with instances of fuzzysort.new()
  var isNode = typeof require !== 'undefined' && typeof window === 'undefined'
  // var MAX_INT = Number.MAX_SAFE_INTEGER
  // var MIN_INT = Number.MIN_VALUE
  var preparedCache = new Map()
  var preparedSearchCache = new Map()
  var noResults = []; noResults.total = 0
  var matchesSimple = []; var matchesStrict = []
  function cleanup() { preparedCache.clear(); preparedSearchCache.clear(); matchesSimple = []; matchesStrict = [] }
  function defaultScoreFn(a) {
    var max = -9007199254740991
    for (var i = a.length - 1; i >= 0; --i) {
      var result = a[i]; if (result === null) continue
      var score = result.score
      if (score > max) max = score
    }
    if (max === -9007199254740991) return null
    return max
  }

  // prop = 'key'              2.5ms optimized for this case, seems to be about as fast as direct obj[prop]
  // prop = 'key1.key2'        10ms
  // prop = ['key1', 'key2']   27ms
  function getValue(obj, prop) {
    var tmp = obj[prop]; if (tmp !== undefined) return tmp
    var segs = prop
    if (!Array.isArray(prop)) segs = prop.split('.')
    var len = segs.length
    var i = -1
    while (obj && (++i < len)) obj = obj[segs[i]]
    return obj
  }

  function isObj(x) { return typeof x === 'object' } // faster as a function

  // Hacked version of https://github.com/lemire/FastPriorityQueue.js
  var fastpriorityqueue = function () { var r = [], o = 0, e = {}; function n() { for (var e = 0, n = r[e], c = 1; c < o;) { var f = c + 1; e = c, f < o && r[f].score < r[c].score && (e = f), r[e - 1 >> 1] = r[e], c = 1 + (e << 1) } for (var a = e - 1 >> 1; e > 0 && n.score < r[a].score; a = (e = a) - 1 >> 1)r[e] = r[a]; r[e] = n } return e.add = function (e) { var n = o; r[o++] = e; for (var c = n - 1 >> 1; n > 0 && e.score < r[c].score; c = (n = c) - 1 >> 1)r[n] = r[c]; r[n] = e }, e.poll = function () { if (0 !== o) { var e = r[0]; return r[0] = r[--o], n(), e } }, e.peek = function (e) { if (0 !== o) return r[0] }, e.replaceTop = function (o) { r[0] = o, n() }, e };
  var q = fastpriorityqueue() // reuse this, except for async, it needs to make its own

  return fuzzysortNew()
}) // UMD

// TODO: (performance) wasm version!?

// TODO: (performance) layout memory in an optimal way to go fast by avoiding cache misses

// TODO: (performance) preparedCache is a memory leak

// TODO: (like sublime) backslash === forwardslash

// TODO: (performance) i have no idea how well optizmied the allowing typos algorithm is
